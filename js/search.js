const searchInput = document.getElementById("search-input");

searchInput.addEventListener("keydown", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    const searchTerm = searchInput.value;
    // Generate search results using searchTerm
    searchInput.value = searchTerm;
  }
});