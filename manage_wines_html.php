
<!DOCTYPE html>
<html>
<head>
  <title>Wine Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php
  require_once 'header.php';
?>
  <div class="container">
    <br><br>
    <h1>Add New Wine</h1>
    <br>
    <form action="manage_wines.php" method="POST" id="addWineForm">
      <div class="mb-3">
        <label for="addWineName" class="form-label">Wine Name:</label>
        <input type="text" id="addWineName" name="addWineName" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="addVinification" class="form-label">Vinification</label>
        <input type="text" id="addVinification" name="addVinification" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="addAppellation" class="form-label">Appellation</label>
        <input type="text" id="addAppellation" name="addAppellation" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="addVintage" class="form-label">Vintage</label>
        <input type="number" id="addVintage" name="addVintage" class="form-control" required value="2021">
      </div>

      <div class="mb-3">
        <label for="addPrice" class="form-label">Price</label>
        <input type="number" id="addPrice" name="addPrice" class="form-control" required value="100">
      </div>

      <button type="submit" class="btn btn-danger">Insert Wine</button>
    </form>
  </div>

  <div class="container">
    <br><br><br>
    <h1>Remove Wine</h1>
    <br>
    <form action="manage_wines.php" method="POST">
      <div class="mb-3">
        <select id="removeWineName" name="removeWineName" class="form-select" required>
          <option value="" disabled selected>Wine Name</option>
        </select>
      </div>

      <button type="submit" class="btn btn-danger">Remove Wine</button>
    </form>
  </div>

  <script src="manage_wines.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
