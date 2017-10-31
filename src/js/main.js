require('../sass/app.scss');

import SubmitReport from './SubmitReport';
import FAQ from './FAQ';

if (document.getElementById('submitreport')) {
    new SubmitReport();
} else if (document.getElementById('faq')) {
    new FAQ();
}

const shrinkHeader = () => {
    const header = document.getElementById('header');

    if (window.scrollY > 39) {
        header.classList.add('small');
    } else {
        header.classList.remove('small');
    }
}

window.addEventListener('scroll', _ => shrinkHeader());
shrinkHeader();

// "Search"
if (document.getElementById('opensearch')) {
    const [opensearch, search, searchfield] = ['opensearch', 'search', 'input'].map(t => document.getElementById(t));

    searchfield.addEventListener('keyup', ({target}) => {
        [...document.getElementsByClassName('reporttitle')]
            .filter(t => !t.parentElement.classList.remove('hide') && !t.children[0].innerHTML.match(new RegExp(target.value, 'i')))
            .forEach(t => t.parentElement.classList.add('hide'));
    });

    searchfield.addEventListener('blur', e => {
        search.classList.remove('opened');
    });

    opensearch.addEventListener('click', e => {
        search.classList.add('opened');
        searchfield.focus();
    });
}
