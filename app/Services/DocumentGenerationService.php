<?php

namespace App\Services;

use App\Models\DocumentTemplate;
use App\Models\Employee;

class DocumentGenerationService
{
    /**
     * Replace placeholders in the template body with employee data.
     */
    public function render(DocumentTemplate $template, Employee $employee): string
    {
        $placeholders = [
            '{{name}}' => trim($employee->first_name.' '.$employee->last_name),
            '{{designation}}' => $employee->designation,
            '{{department}}' => $employee->department ?? '',
            '{{email}}' => $employee->email,
            '{{date}}' => now()->format('F d, Y'),
            '{{joining_date}}' => optional($employee->date_of_joining)?->format('F d, Y') ?? '',
        ];

        $body = str_replace(array_keys($placeholders), array_values($placeholders), $template->body);

        $typeBadge = str_replace('_', ' ', ucwords($template->type, '_'));
        $subject = $template->subject ?? $template->name;
        $employeeName = trim($employee->first_name.' '.$employee->last_name);
        $date = now()->format('F d, Y');
        $bodyHtml = nl2br(e($body));

        return <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                @page {
                    margin: 0;
                }
                body {
                    font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
                    color: #1a1a1a;
                    margin: 0;
                    padding: 0;
                    font-size: 13px;
                    line-height: 1.7;
                    background: #ffffff;
                }

                /* Header */
                .header {
                    background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
                    color: #ffffff;
                    padding: 30px 50px 25px;
                }
                .header-title {
                    font-size: 22px;
                    font-weight: 700;
                    letter-spacing: 1px;
                    margin: 0;
                }
                .header-subtitle {
                    font-size: 11px;
                    opacity: 0.85;
                    margin-top: 4px;
                    letter-spacing: 0.5px;
                }

                /* Accent bar */
                .accent-bar {
                    height: 4px;
                    background: linear-gradient(90deg, #f59e0b, #ef4444, #8b5cf6, #2563eb);
                }

                /* Body */
                .content {
                    padding: 35px 50px 20px;
                }

                /* Meta info */
                .meta-row {
                    display: table;
                    width: 100%;
                    margin-bottom: 25px;
                    font-size: 12px;
                    color: #4b5563;
                }
                .meta-left {
                    display: table-cell;
                    width: 50%;
                    vertical-align: top;
                }
                .meta-right {
                    display: table-cell;
                    width: 50%;
                    text-align: right;
                    vertical-align: top;
                }
                .meta-label {
                    font-weight: 600;
                    color: #1e3a5f;
                    font-size: 10px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                .meta-value {
                    margin-top: 2px;
                    font-size: 13px;
                    color: #111827;
                }

                /* Document type badge */
                .doc-type {
                    display: inline-block;
                    background: #eff6ff;
                    color: #1e40af;
                    font-size: 10px;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    padding: 5px 14px;
                    border-radius: 4px;
                    border: 1px solid #bfdbfe;
                    margin-bottom: 15px;
                }

                /* Subject */
                .subject {
                    font-size: 18px;
                    font-weight: 700;
                    color: #1e3a5f;
                    margin: 0 0 20px;
                    padding-bottom: 12px;
                    border-bottom: 2px solid #e5e7eb;
                }

                /* Letter body */
                .letter-body {
                    font-size: 13px;
                    color: #374151;
                    line-height: 1.8;
                    text-align: justify;
                }

                /* Signature area */
                .signature {
                    margin-top: 50px;
                    padding-top: 20px;
                }
                .sig-line {
                    width: 200px;
                    border-top: 2px solid #1e3a5f;
                    margin-bottom: 5px;
                }
                .sig-name {
                    font-weight: 700;
                    color: #1e3a5f;
                    font-size: 13px;
                }
                .sig-title {
                    font-size: 11px;
                    color: #6b7280;
                }

                /* Footer */
                .footer {
                    position: fixed;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    background: #f9fafb;
                    border-top: 1px solid #e5e7eb;
                    padding: 12px 50px;
                    font-size: 10px;
                    color: #9ca3af;
                    text-align: center;
                }
                .footer strong {
                    color: #6b7280;
                }

                /* Watermark */
                .watermark {
                    position: fixed;
                    top: 45%;
                    left: 50%;
                    transform: translate(-50%, -50%) rotate(-30deg);
                    font-size: 80px;
                    color: rgba(30, 58, 95, 0.03);
                    font-weight: 900;
                    letter-spacing: 10px;
                    text-transform: uppercase;
                    z-index: -1;
                    white-space: nowrap;
                }
            </style>
        </head>
        <body>
            <div class="watermark">HR DOCUMENT</div>

            <div class="header">
                <p class="header-title">HR Document System</p>
                <p class="header-subtitle">Automated HR Document Generation &amp; Email System</p>
            </div>
            <div class="accent-bar"></div>

            <div class="content">
                <span class="doc-type">{$typeBadge}</span>

                <div class="meta-row">
                    <div class="meta-left">
                        <p class="meta-label">Issued To</p>
                        <p class="meta-value">{$employeeName}</p>
                    </div>
                    <div class="meta-right">
                        <p class="meta-label">Date</p>
                        <p class="meta-value">{$date}</p>
                    </div>
                </div>

                <h2 class="subject">{$subject}</h2>

                <div class="letter-body">
                    {$bodyHtml}
                </div>

                <div class="signature">
                    <div class="sig-line"></div>
                    <p class="sig-name">Authorized Signatory</p>
                    <p class="sig-title">Human Resources Department</p>
                </div>
            </div>

            <div class="footer">
                <strong>HR Document System</strong> &mdash; This is a system-generated document. &mdash; Generated on {$date}
            </div>
        </body>
        </html>
        HTML;
    }
}
