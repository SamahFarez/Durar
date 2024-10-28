var values = ["حاضر", "غائب", "عذر"];
var colors = ["#AEF7B5", "#FBBCAE", "#81DFF3"];
var currentIndex = 0;



function changeState() {
  console.log("changeState function called"); // Check if the function is called

  var valueInput = document.getElementById("student_state");
  var parent = document.getElementById("parent");

  // Update the input value
  valueInput.value = values[currentIndex];

  // Update the parent background color
  parent.style.backgroundColor = colors[currentIndex];

  // Increment the index or reset to 0 if it exceeds the length of values
  currentIndex = (currentIndex + 1) % values.length;
}
