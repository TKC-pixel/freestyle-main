function googleTranslateElementInit() {
    new google.translate.TranslateElement(
        { pageLanguage: 'en' },
        'google_translate_element'
    );
}

let count=0;
document.getElementById('dark').addEventListener('click', function(){
    count++;
    if(count%2!=0 ){
        console.log('here');
        document.getElementById('main').style.backgroundColor='black';
        document.getElementById('main').style.color='white';
    }
    else{
        document.getElementById('main').style.backgroundColor = '#a9d7e9';
        document.getElementById('main').style.color = 'black';
    }
});
