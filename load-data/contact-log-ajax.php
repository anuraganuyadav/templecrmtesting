<?php
require_once('../inc/config.php');

$sql = "
    SELECT 
        l.id, 
        l.name, 
        l.email, 
        l.mo_number, 
        COALESCE(p.wtp_no, l.wtp_no) AS wtp_no, 
        l.destination
    FROM lead l
    LEFT JOIN potential p ON l.mo_number = p.mo_number
    
    UNION
    SELECT 
        p.id, 
        p.name, 
        p.email, 
        p.mo_number, 
        p.wtp_no, 
        p.destination
    FROM potential p
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die(json_encode(['error' => mysqli_error($conn)]));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode(['data' => $data]);
