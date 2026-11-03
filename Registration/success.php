<?php
session_start();
if (empty($_SESSION['registration'])) { header('Location: index.php'); exit; }
$data = $_SESSION['registration'];
$reference = $_SESSION['reference'];
$submittedAt = $_SESSION['submitted_at'];
unset($_SESSION['registration'], $_SESSION['reference'], $_SESSION['submitted_at']);
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="theme-color" content="#07101b"><title>Registration Successful — Mission Control</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="css/style.css"></head>
<body class="receipt-body"><header class="topbar"><a class="brand" href="index.php"><span class="brand-mark">M<span>·</span></span><span>MISSION<br>CONTROL</span></a><span class="system-state"><i></i> TRANSMISSION RECEIVED</span></header>
<main class="receipt-wrap"><div class="receipt-top"><div class="success-mark">✓</div><p class="eyebrow"><span>APPLICATION RECEIPT / <?= e($reference) ?></span><span>STATUS: CONFIRMED</span></p><h1>REGISTRATION<br><em>SUCCESSFUL</em><span class="period">.</span></h1><p class="receipt-intro">Your application has reached Mission Control. Keep this reference for your records.</p></div>
<section class="receipt-card"><div class="receipt-card-head"><span>APPLICANT DOSSIER</span><span>FILED <?= e($submittedAt) ?></span></div><div class="reference"><span>MISSION REFERENCE</span><strong><?= e($reference) ?></strong></div><div class="receipt-grid"><div><span>APPLICANT</span><strong><?= e($data['full_name']) ?></strong></div><div><span>EMAIL</span><strong><?= e($data['email']) ?></strong></div><div><span>PHONE</span><strong><?= e($data['phone']) ?></strong></div><div><span>COLLEGE</span><strong><?= e($data['college']) ?></strong></div><div><span>DEPARTMENT</span><strong><?= e($data['department']) ?></strong></div><div><span>STUDENT ID</span><strong><?= e($data['student_id']) ?></strong></div><div><span>YEAR OF STUDY</span><strong><?= e($data['year']) ?></strong></div><div><span>AREA OF INTEREST</span><strong><?= e($data['interest']) ?></strong></div></div><div class="receipt-stamp">MISSION<br>CONTROL<br><b>✓ FILED</b></div></section>
<div class="receipt-actions"><button class="button button-primary" onclick="window.print()">PRINT APPLICATION <span>⌑</span></button><a class="button button-quiet" href="index.php">← RETURN TO MISSION CONTROL</a></div></main>
<footer><a class="brand" href="index.php"><span class="brand-mark">M<span>·</span></span><span>MISSION<br>CONTROL</span></a><span>STUDENT INNOVATION PROGRAMME · 2026</span><span>END OF TRANSMISSION</span></footer></body></html>
