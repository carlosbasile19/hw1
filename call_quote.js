
fetch('https://api.quotable.io/random')
  .then(response => response.json())
  .then(data => {
    const quote = `${data.content} —${data.author}`;
    const h2Element = document.querySelector('h2');
    h2Element.innerHTML = quote;
  })
  .catch(err => console.log(err));