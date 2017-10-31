class FAQ {
    constructor() {
        [...document.getElementsByClassName('faqitem')].forEach(faqitem => {
            const [q, a] = ['question', 'answer'].map(el => faqitem.querySelector('.' + el));
            a.classList.add('hide');
            q.addEventListener('click', e => a.classList.toggle('hide'));
        });
    }
}

export default FAQ;
