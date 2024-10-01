//Braden Held
//10-4-23
//CPSC 3750
//Program Exam #1 
//A

var primeArr = [];
var nonPrimeArr = [];

var primeListBG = document.getElementById("prime-list-container");
var nonPrimeListBG = document.getElementById("non-prime-list-container");
primeListBG.style.background = "rgb(" + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + ")";
nonPrimeListBG.style.background = "rgb(" + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + ")";

function isPrime(input) {
    if (input == 1) return false;
    if (input == 2) return true;

    for (var i = 2; i < input; i++) {
        if (input % i == 0) {
            return false;
        }
    }
    return true;
}

function createLists() {
    var userInput = document.getElementById("number").value;
    var primeList = document.getElementById("prime-list");
    var nonPrimeList = document.getElementById("non-prime-list");

    for (var i = 1; i <= userInput; i++) {

        if (isPrime(i)) {
            primeList.innerHTML += "<li>" + i + "</li>";
            primeArr.push(i);
        } else {
            nonPrimeList.innerHTML += "<li>" + i + "</li>";
            nonPrimeArr.push(i);
        }
    }
}

function changeBGColor() {
    var primeListBG = document.getElementById("prime-list-container");
    var nonPrimeListBG = document.getElementById("non-prime-list-container");

    primeListBG.style.background = "rgb(" + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + ")";
    nonPrimeListBG.style.background = "rgb(" + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + ")";
}

let changeBG = setInterval(changeBGColor, 5000);

function sumListPrime() {
    var sum = 0;
    for (var i = 0; i < primeArr.length; i++) {
        sum += primeArr[i];
    }

    var primeSum = document.getElementById("sum-prime");
    primeSum.innerHTML = sum;
}

function sumListNonPrime() {
    var sum = 0;
    for (var i = 0; i < nonPrimeArr.length; i++) {
        sum += nonPrimeArr[i];
    }

    var nonPrimeSum = document.getElementById("sum-non-prime");
    nonPrimeSum.innerHTML = sum;
}