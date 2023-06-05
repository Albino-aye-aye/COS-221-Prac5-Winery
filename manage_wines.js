var wineryID = localStorage.getItem("WineryID");

// Populating Wine Names into the Remove Wine Dropdown
function populateRemoveWineNames() {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "manage_wines.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      var data = JSON.parse(xhr.responseText);
      var removeWineNameSelect = document.getElementById("removeWineName");

      removeWineNameSelect.innerHTML = "";

      var defaultOption = document.createElement("option");
      defaultOption.value = "";
      defaultOption.disabled = true;
      defaultOption.selected = true;
      defaultOption.textContent = "Wine Name";
      removeWineNameSelect.appendChild(defaultOption);

      data.forEach(function (wine) {
        var option = document.createElement("option");
        option.value = wine.WineID;
        option.textContent = wine.name;
        removeWineNameSelect.appendChild(option);
      });
    } else {
      console.error("Request failed. Status:", xhr.status);
    }
  };

  var params = "wineryID=" + encodeURIComponent(wineryID);
  xhr.send(params);
}

document.addEventListener("DOMContentLoaded", populateRemoveWineNames);

// Form submission validation
var addWineForm = document.getElementById("addWineForm");
addWineForm.addEventListener("submit", function (event) {
  var addWineName = document.getElementById("addWineName");
  var addVinification = document.getElementById("addVinification");
  var addAppellation = document.getElementById("addAppellation");
  var addVintage = document.getElementById("addVintage");
  var addPrice = document.getElementById("addPrice");
  var error = false;
  var errors = [];

  if (addWineName.value === "") {
    error = true;
    addWineName.style.backgroundColor = "red";
    setTimeout(function () {
      addWineName.style.backgroundColor = "";
    }, 2000);
    errors.push("Missing Wine Name");
  }

  if (addVinification.value === "") {
    error = true;
    addVinification.style.backgroundColor = "red";
    setTimeout(function () {
      addVinification.style.backgroundColor = "";
    }, 2000);
    errors.push("Missing Vinfication");
  }

  if (addAppellation.value === "") {
    error = true;
    addAppellation.style.backgroundColor = "red";
    setTimeout(function () {
      addAppellation.style.backgroundColor = "";
    }, 2000);
    errors.push("Missing Appelation");
  }

  var vintageRegex = /^\d+$/;
  if (!vintageRegex.test(addVintage.value) || addVintage.value === "") {
    error = true;
    addVintage.style.backgroundColor = "red";
    setTimeout(function () {
      addVintage.style.backgroundColor = "";
    }, 2000);
    errors.push("Vintange must be a number");
  }

  var priceRegex = /^\d+(\.\d{1,2})?$/;
  if (!priceRegex.test(addPrice.value) || addPrice.value === "") {
    error = true;
    addPrice.style.backgroundColor = "red";
    setTimeout(function () {
      addPrice.style.backgroundColor = "";
    }, 2000);
    errors.push("Price must be a number");
  }

  if (error) {
    event.preventDefault();
    alert(errors.join("\n"));
  }
});
