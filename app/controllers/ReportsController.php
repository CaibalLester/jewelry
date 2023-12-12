<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class ReportsController extends Controller
{
    public function reports()
    {
        $data['today'] = $this->Reports_model->getTodaySales();
        $data['monthly'] = $this->Reports_model->getMonthlySales();
        $data['yearly'] = $this->Reports_model->getYearlySales();
        $data['weekly'] = $this->Reports_model->getWeeklySales();
        $data['overall_sales'] = $this->Reports_model->getOverallSales();
        
        $this->call->view('admin/reports', $data);
    }

    public function downloadReportsPdf()
    {
        // Get data from the form submission
        $today = $this->io->post('today');
        $weekly = $this->io->post('weekly');
        $monthly = $this->io->post('monthly');
        $overall_sales = $this->io->post('overall_sales');

        // Load TCPDF library
        // require_once 'C:\laragon\www\jewelry\vendor\tecnickcom\tcpdf\tcpdf.php';

        // Create instance of TCPDF
        $pdf = new TCPDF();

        // Set document properties
        $pdf->SetCreator('Jandel');
        $pdf->SetAuthor('Escalera');
        $pdf->SetTitle('Sales Reports');
        $pdf->SetSubject('Sales Reports');
        $pdf->SetKeywords('Sales, Reports');

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('times', '', 12);

        // Add content to the PDF
        $content = '
            <h1>Sales Report</h1>
            <table border="1">
                <thead>
                    <tr>
                        <th>Today</th>
                        <th>Weekly</th>
                        <th>Monthly</th>
                        <th>Overall Sales</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>' . 'Php' . number_format($today, 2) . '</td>
                        <td>' . 'Php' . number_format($weekly, 2) . '</td>
                        <td>' . 'Php' . number_format($monthly, 2) . '</td>
                        <td>' . 'Php' . number_format($overall_sales, 2) . '</td>
                    </tr>
                </tbody>
            </table>
        ';

        $pdf->writeHTML($content, true, false, true, false, '');

        // Output the PDF as a download
        $pdf->Output('sales_reports.pdf', 'D');
        return redirect('reports');
    }
}
?>
