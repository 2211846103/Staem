function search() {
    const query = document.getElementById('query').value;
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `Search_result.php?q=${query}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('results').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}