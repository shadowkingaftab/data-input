<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
$fields = ['full_name','email','phone','dob','gender','college','department','year','student_id','interest','motivation'];
$data = [];
foreach ($fields as $field) $data[$field] = trim((string)($_POST[$field] ?? ''));
$data['agreement'] = isset($_POST['agreement']) ? 'yes' : '';
$labels = ['full_name'=>'Full name','email'=>'Email address','phone'=>'Phone number','dob'=>'Date of birth','gender'=>'Gender','college'=>'College name','department'=>'Department','year'=>'Year of study','student_id'=>'Student registration number','interest'=>'Area of interest','motivation'=>'Motivation'];
$errors = [];
foreach ($labels as $key=>$label) if ($data[$key] === '') $errors[] = "$label is required.";
if ($data['full_name'] !== '' && mb_strlen($data['full_name']) > 100) $errors[] = 'Full name must be 100 characters or fewer.';
if ($data['email'] !== '' && (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strlen($data['email']) > 254)) $errors[] = 'Enter a valid email address.';
if ($data['phone'] !== '' && !preg_match('/^[0-9+().\s-]{7,20}$/', $data['phone'])) $errors[] = 'Enter a valid phone number (7–20 characters).';
$date = DateTime::createFromFormat('!Y-m-d', $data['dob']);
if ($data['dob'] !== '' && (!$date || $date->format('Y-m-d') !== $data['dob'] || $date > new DateTime('today'))) $errors[] = 'Enter a valid date of birth that is not in the future.';
$allowed = ['gender'=>['Woman','Man','Non-binary','Prefer not to say','Self-describe'],'year'=>['1st Year','2nd Year','3rd Year','4th Year','5th Year','Postgraduate'],'interest'=>['Artificial Intelligence & Data','Robotics & Space Systems','Sustainability & Climate','Design & Human Experience','Entrepreneurship & Product','Research & Emerging Science']];
foreach ($allowed as $key=>$options) if ($data[$key] !== '' && !in_array($data[$key], $options, true)) $errors[] = 'Select a valid '.$labels[$key].'.';
foreach (['college'=>150,'department'=>100,'student_id'=>40] as $key=>$limit) if (mb_strlen($data[$key]) > $limit) $errors[] = $labels[$key]." must be $limit characters or fewer.";
if ($data['motivation'] !== '' && (mb_strlen($data['motivation']) < 50 || mb_strlen($data['motivation']) > 700)) $errors[] = 'Motivation must be between 50 and 700 characters.';
if (!$data['agreement']) $errors[] = 'You must confirm the accuracy of your information.';
if ($errors) { $_SESSION['form_errors'] = $errors; $_SESSION['form_old'] = $data; header('Location: index.php#apply', true, 303); exit; }
$_SESSION['registration'] = $data;
$_SESSION['reference'] = 'MC-'.date('y').'-'.strtoupper(bin2hex(random_bytes(4)));
$_SESSION['submitted_at'] = date('Y-m-d H:i:s T');
header('Location: success.php', true, 303); exit;
