//Get the data from php file
$.ajax({
    url: 'vowelCount.php',
    type: 'GET',
    success: function(data) {
        var buttonsDiv = document.getElementById('buttons');

        //Create buttons for each vowel count
        for (var count in data) {
            var button = document.createElement('button');
            button.innerHTML = count;
            button.onclick = function() {
                var vowels = this.innerHTML;
                var words = data[vowels];
                var wordListDiv = document.getElementById('wordList');
                wordListDiv.innerHTML = '';

                var ul = document.createElement('ul');
                for (var i = 0; i < words.length; i++) {
                    var li = document.createElement('li');
                    li.draggable = true;
                    li.setAttribute('ondragstart', 'drag(event)');
                    li.appendChild(document.createTextNode(words[i]));
                    ul.appendChild(li);
                }
                wordListDiv.appendChild(ul);
            };
            buttonsDiv.appendChild(button);
        }
    }
});

var dropCount = 0;

document.getElementById('dropArea').ondragover = function(event) {
    event.preventDefault();
};

function drag(event) {
    ev.dataTransfer.setData("text", event.target.innerText);
}

function drop(event) {
    event.preventDefault();
    var data = event.dataTransfer.getData("text");
    event.target.innerText += "\n" + data;
    //Could not get this to display the drop count
    dropCount++;
    document.getElementById('wordCount').innerText = dropCount;
    console.log(dropCount)
}