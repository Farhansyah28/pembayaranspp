<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran #
        <?= $p->id ?>
    </title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
            position: relative;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0;
        }

        .nota-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ccc;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .signature {
            text-align: center;
            width: 200px;
        }

        .signature div {
            margin-top: 80px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .amount-box {
            border: 2px solid #000;
            padding: 10px;
            font-weight: bold;
            font-size: 18px;
            display: inline-block;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 0;
            }

            .container {
                border: none;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()"
            style="padding: 10px 20px; cursor: pointer; background: #2563eb; color: #fff; border: none; border-radius: 5px;">Cetak
            Sekarang (Ctrl+P)</button>
        <button onclick="window.history.back()"
            style="padding: 10px 20px; cursor: pointer; background: #eee; border: none; border-radius: 5px;">Kembali</button>
    </div>

    <div class="container">
        <div class="header">
            <?php if ($settings->logo_pesantren && file_exists('./uploads/branding/' . $settings->logo_pesantren)): ?>
                <img src="<?= base_url('uploads/branding/' . $settings->logo_pesantren) ?>"
                    style="height: 60px; margin-bottom: 10px;" alt="Logo">
            <?php endif; ?>
            <h1><?= strtoupper($settings->nama_pesantren ?? 'PONDOK PESANTREN DEMO') ?></h1>
            <p><?= $settings->alamat_pesantren ?? 'Jl. Pendidikan No. 123, Kota Santri - Indonesia' ?></p>
            <p>Telp: <?= $settings->telepon_pesantren ?? '021-12345678' ?></p>
        </div>

        <div style="text-align: center; text-decoration: underline; margin-bottom: 20px;">
            <h3>KWITANSI PEMBAYARAN SPP</h3>
        </div>

        <div class="nota-info">
            <div>
                <strong>No. Transaksi:</strong> #PAY-
                <?= str_pad($p->id, 5, '0', STR_PAD_LEFT) ?><br>
                <strong>Tgl. Bayar:</strong>
                <?= date('d/m/Y H:i', strtotime($p->tanggal_bayar)) ?><br>
                <strong>Metode:</strong>
                <?= $p->metode ?><br>
                <strong>Status:</strong> BERHASIL (LUNAS)
            </div>
            <div style="text-align: right;">
                <?php
                $verify_url = base_url('verify/payment/' . $p->id . '/' . md5($p->id . 'PESANTREN_QR_SECURE_2024'));
                $qr_api = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($verify_url);
                ?>
                <img src="<?= $qr_api ?>" alt="Verify QR" style="border: 1px solid #eee; padding: 5px;">
                <div style="font-size: 8px; color: #666; margin-top: 5px;">Scan untuk Verifikasi</div>
            </div>
        </div>

        <table class="table">
            <tr>
                <th width="30%">NIS</th>
                <td>:
                    <?= $p->nis ?>
                </td>
            </tr>
            <tr>
                <th>Nama Santri</th>
                <td>:
                    <?= $p->santri_nama ?>
                </td>
            </tr>
            <tr>
                <th>Kelas</th>
                <td>:
                    <?= $p->kelas_nama ?>
                </td>
            </tr>
            <tr>
                <th>Untuk Pembayaran</th>
                <td>: SPP Bulan
                    <?= date('F Y', mktime(0, 0, 0, $p->bulan, 10, $p->tahun)) ?>
                </td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>:
                    <?= $p->catatan ?: '-' ?>
                </td>
            </tr>
        </table>

        <div class="amount-box">
            Terbilang: Rp
            <?= number_format($p->jumlah, 0, ',', '.') ?>
        </div>

        <div style="margin-top: 15px; font-size: 12px; font-style: italic;">
            * Sisa Tagihan Bulan Ini: Rp
            <?= number_format(max(0, $p->nominal_akhir - $total_bayar), 0, ',', '.') ?>
        </div>

        <div class="footer">
            <div>
                <em>Dicetak secara otomatis oleh sistem pada
                    <?= date('d/m/Y H:i') ?>
                </em>
            </div>
            <div class="signature">
                Kota Santri,
                <?= date('d/m/Y') ?><br>
                Bendahara,<br>
                <div>
                    <?= $p->admin_nama ?: 'Admin SPP' ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto print context menu or just let user decide
        // window.print();
    </script>
</body>

</html>