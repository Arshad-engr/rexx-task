<!DOCTYPE html>
<html>

<head>
    <title>Booking Records</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        input[type=text] {
            padding: 5px;
            width: 200px;
        }

        input[type=file] {
            padding: 5px;
            width: 200px;
        }

        button {
            padding: 6px 12px;
        }

        form {
            margin-left: 5px;
            margin-right: 50px;
        }

        .forms {
            display: flex;
        }
    </style>
</head>

<body>
    <h2>Rexx Event Booking System</h2>
    <div class="forms">
        <form method="GET" name="filter">
            <input type="hidden" name="action" value="view">
            <input type="text" name="search_keyword" placeholder="Search Employee/Event Name/Event Date"
                value="<?= htmlspecialchars($filters['search_keyword'] ?? '') ?>">
            <button type="submit">Filter</button>
        </form>
        <!-- <form method="GET" name = "importClass">
        <input type="hidden" name="action" value="import">
        <input type="file" name="json_file" placeholder="Import json file">
        <button type="submit">Submit</button>
    </form> -->
        <form method="POST" enctype="multipart/form-data">
            <label>Import Json File:</label>
            <input type="file" name="json_file" accept=".json" required>
            <button type="submit" name="import">Import</button>
        </form>
    </div>

    <br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee Name</th>
                <th>Email</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Participation Fee</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($bookings)):
                   $totalFee=0;
                ?>
                <?php foreach ($bookings as $row): 
                      $totalFee+=$row['participation_fee'];
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['employee_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['event_name']) ?></td>
                        <td><?= htmlspecialchars($row['event_date']) ?></td>
                        <td><?= htmlspecialchars($row['participation_fee']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No records found.</td>
                </tr>
            <?php endif;
            if (!empty($bookings)): ?>
            <tfoot>
                <tr>
                    <td colspan="5">Total Participants Fee:</td>
                    <td><?=$totalFee ?></td>
                </tr>
            </tfoot>
            <?php endif ?>
        </tbody>
    </table>
</body>

</html>