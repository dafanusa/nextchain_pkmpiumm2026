<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FinancialReportFilterRequest;
use App\Http\Requests\Admin\StoreFinancialReportRequest;
use App\Models\FinancialReport;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FinancialReportController extends Controller
{
    public function index(FinancialReportFilterRequest $request): View
    {
        $filters = $request->validated();
        $dateFrom = $filters['date_from'] ?? null;
        $dateTo = $filters['date_to'] ?? null;

        $ordersQuery = Order::query()
            ->with(['user', 'payments'])
            ->orderByDesc('id');

        if ($dateFrom) {
            $ordersQuery->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $ordersQuery->whereDate('created_at', '<=', $dateTo);
        }

        $orders = $ordersQuery->get();
        $summaryOrders = $orders->count();
        $summaryTotal = $orders->sum('total');
        $summaryPaid = $orders->where('payment_status', 'paid')->sum('total');

        $reports = FinancialReport::query()
            ->with('creator')
            ->latest()
            ->paginate(10);

        return view('admin.financial-reports.index', [
            'orders' => $orders,
            'reports' => $reports,
            'summaryOrders' => $summaryOrders,
            'summaryTotal' => $summaryTotal,
            'summaryPaid' => $summaryPaid,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    public function store(StoreFinancialReportRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $orderIds = $validated['order_ids'];

        $orders = Order::query()
            ->with(['user', 'payments'])
            ->whereIn('id', $orderIds)
            ->get();

        if ($orders->isEmpty()) {
            return redirect()->route('admin.financial-reports.index')
                ->withErrors(['order_ids' => 'Order yang dipilih tidak ditemukan.']);
        }

        $reportName = $validated['report_name'] ?? null;
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        FinancialReport::query()->create([
            'report_name' => $reportName,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'order_ids' => $orders->pluck('id')->values()->all(),
            'total_orders' => $orders->count(),
            'total_amount' => $orders->sum('total'),
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ],
            'created_by' => $request->user()?->id,
        ]);

        return redirect()->route('admin.financial-reports.index')->with('success', 'Laporan keuangan tersimpan.');
    }

    public function csv(FinancialReport $report): StreamedResponse
    {
        $orders = $this->getReportOrders($report);
        $filename = $this->makeFilename($report, 'csv');

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($orders, $report) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'No',
                'Order Number',
                'Customer',
                'Total',
                'Status',
                'Payment Status',
                'Payment Method',
                'Paid At',
                'Created At',
            ]);

            $index = 1;
            foreach ($orders as $order) {
                $payment = $order->payments->sortByDesc('paid_at')->first()
                    ?? $order->payments->sortByDesc('created_at')->first();

                fputcsv($handle, [
                    $index,
                    $order->order_number,
                    $order->user?->name ?? $order->buyer_name ?? 'Guest',
                    $order->total,
                    $order->status,
                    $order->payment_status,
                    $payment?->method ?? '-',
                    $payment?->paid_at?->timezone('Asia/Jakarta')->format('Y-m-d H:i') ?? '-',
                    $order->created_at?->timezone('Asia/Jakarta')->format('Y-m-d H:i') ?? '-',
                ]);
                $index++;
            }

            fputcsv($handle, []);
            fputcsv($handle, ['Total Order', $report->total_orders]);
            fputcsv($handle, ['Total Pendapatan', $report->total_amount]);

            fclose($handle);
        }, 200, $headers);
    }

    public function download(FinancialReport $report): Response
    {
        $orders = $this->getReportOrders($report);

        return Pdf::loadView('admin.financial-reports.pdf', [
            'report' => $report,
            'orders' => $orders,
        ])->setPaper('a4', 'portrait')
            ->download($this->makeFilename($report, 'pdf'));
    }

    public function destroy(FinancialReport $report): RedirectResponse
    {
        $report->delete();

        return redirect()->route('admin.financial-reports.index')->with('success', 'Laporan berhasil dihapus.');
    }

    private function getReportOrders(FinancialReport $report)
    {
        $orderIds = $report->order_ids ?? [];

        return Order::query()
            ->with(['user', 'payments'])
            ->whereIn('id', $orderIds)
            ->orderByDesc('id')
            ->get();
    }

    private function makeFilename(FinancialReport $report, string $extension): string
    {
        $range = $report->date_from && $report->date_to
            ? $report->date_from->format('Ymd').'-'.$report->date_to->format('Ymd')
            : now()->format('Ymd');

        $prefix = $report->report_name
            ? str_replace(' ', '-', strtolower($report->report_name))
            : 'laporan-keuangan';

        return $prefix.'-'.$range.'.'.$extension;
    }
}
