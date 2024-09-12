let questions = document.querySelectorAll('.question');
let a = document.querySelectorAll('.a');
let arrow = document.querySelectorAll('.arrow');

for (let i = 0; i < questions.length; i++){
    questions[i].addEventListener('click',() =>{
        a[i].classList.toggle('a-opened');
        arrow[i].classList.toggle('arrow-rotated');

    });
}