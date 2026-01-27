<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExpenseReportFilterRequest;
use App\Http\Requests\Admin\StoreExpenseRequest;
use App\Models\Expense;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExpenseController extends Controller
{
    public function index(ExpenseReportFilterRequest $request): View
    {
        $filters = $request->validated();
        $dateFrom = $filters['date_from'] ?? null;
        $dateTo = $filters['date_to'] ?? null;
        $groupBy = $filters['group_by'] ?? 'daily';

        $expensesQuery = Expense::query()
            ->with('creator')
            ->orderByDesc('expense_date')
            ->orderByDesc('id');

        if ($dateFrom) {
            $expensesQuery->whereDate('expense_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $expensesQuery->whereDate('expense_date', '<=', $dateTo);
        }

        $expenses = $expensesQuery->get();
        $summaryCount = $expenses->count();
        $summaryTotal = $expenses->sum('amount');

        $grouped = $this->groupExpenses($expenses, $groupBy);

        return view('admin.expenses.index', [
            'expenses' => $expenses,
            'summaryCount' => $summaryCount,
            'summaryTotal' => $summaryTotal,
            'grouped' => $grouped,
            'groupBy' => $groupBy,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Expense::query()->create([
            'expense_date' => $validated['expense_date'],
            'amount' => $validated['amount'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'created_by' => $request->user()?->id,
        ]);

        return redirect()->route('admin.expenses.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $expense->delete();

        return redirect()->route('admin.expenses.index')->with('success', 'Pengeluaran berhasil dihapus.');
    }

    public function csv(ExpenseReportFilterRequest $request): StreamedResponse
    {
        $filters = $request->validated();
        $groupBy = $filters['group_by'] ?? 'daily';
        [$expenses, $grouped] = $this->getFilteredExpenses($filters, $groupBy);

        $filename = $this->makeFilename('csv', $filters, $groupBy);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($expenses, $grouped, $groupBy) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No', 'Tanggal', 'Kategori', 'Jumlah', 'Catatan', 'Dibuat Oleh']);

            $index = 1;
            foreach ($expenses as $expense) {
                fputcsv($handle, [
                    $index,
                    $expense->expense_date?->format('Y-m-d'),
                    $expense->category,
                    $expense->amount,
                    $expense->description ?? '-',
                    $expense->creator?->name ?? 'Admin',
                ]);
                $index++;
            }

            fputcsv($handle, []);
            fputcsv($handle, ['Ringkasan', strtoupper($groupBy)]);
            fputcsv($handle, ['Periode', 'Total']);
            foreach ($grouped as $row) {
                fputcsv($handle, [$row['label'], $row['total']]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function download(ExpenseReportFilterRequest $request)
    {
        $filters = $request->validated();
        $groupBy = $filters['group_by'] ?? 'daily';
        [$expenses, $grouped] = $this->getFilteredExpenses($filters, $groupBy);
        $summaryTotal = $expenses->sum('amount');

        return Pdf::loadView('admin.expenses.pdf', [
            'expenses' => $expenses,
            'grouped' => $grouped,
            'groupBy' => $groupBy,
            'dateFrom' => $filters['date_from'] ?? null,
            'dateTo' => $filters['date_to'] ?? null,
            'summaryTotal' => $summaryTotal,
        ])->setPaper('a4', 'portrait')
            ->download($this->makeFilename('pdf', $filters, $groupBy));
    }

    private function getFilteredExpenses(array $filters, string $groupBy): array
    {
        $expensesQuery = Expense::query()
            ->with('creator')
            ->orderByDesc('expense_date')
            ->orderByDesc('id');

        if (! empty($filters['date_from'])) {
            $expensesQuery->whereDate('expense_date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $expensesQuery->whereDate('expense_date', '<=', $filters['date_to']);
        }

        $expenses = $expensesQuery->get();
        $grouped = $this->groupExpenses($expenses, $groupBy);

        return [$expenses, $grouped];
    }

    private function groupExpenses($expenses, string $groupBy): array
    {
        if ($expenses->isEmpty()) {
            return [];
        }

        return $expenses
            ->groupBy(function (Expense $expense) use ($groupBy) {
                $date = $expense->expense_date?->timezone('Asia/Jakarta') ?? Carbon::now('Asia/Jakarta');

                return match ($groupBy) {
                    'weekly' => $date->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
                    'monthly' => $date->format('Y-m'),
                    default => $date->format('Y-m-d'),
                };
            })
            ->map(function ($items, $key) use ($groupBy) {
                $label = match ($groupBy) {
                    'weekly' => $this->formatWeekLabel($key),
                    'monthly' => Carbon::createFromFormat('Y-m', $key)->format('M Y'),
                    default => Carbon::parse($key)->format('d M Y'),
                };

                return [
                    'key' => $key,
                    'label' => $label,
                    'total' => $items->sum('amount'),
                    'count' => $items->count(),
                ];
            })
            ->values()
            ->all();
    }

    private function formatWeekLabel(string $startDate): string
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = $start->copy()->endOfWeek(Carbon::SUNDAY);

        return $start->format('d M').' - '.$end->format('d M');
    }

    private function makeFilename(string $extension, array $filters, string $groupBy): string
    {
        $range = (! empty($filters['date_from']) && ! empty($filters['date_to']))
            ? str_replace('-', '', $filters['date_from']).'-'.str_replace('-', '', $filters['date_to'])
            : now()->format('Ymd');

        return 'laporan-pengeluaran-'.$groupBy.'-'.$range.'.'.$extension;
    }
}
