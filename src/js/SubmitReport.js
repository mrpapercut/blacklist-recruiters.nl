import request from 'superagent';

class SubmitReport {

    constructor() {
        this.mapElements();

        const {form, jsWarning, submitbtn} = this.elements;

        form.addEventListener('submit', e => {
            e.preventDefault();
            this.submit();
        });

        jsWarning.classList.add('hide');
        submitbtn.removeAttribute('disabled');

        this.resetErrors();
        this.attachNewCompanyField();
    }

    mapElements() {
        const elements = {
            form: document.getElementById('submitreport'),
            jsWarning: document.getElementById('js-warning')
        };

        ['company', 'newcompany', 'name', 'report', 'peoplecheck', 'submitbtn'].forEach(id => {
            elements[id] = elements.form.querySelector('#' + id);
        });

        this.elements = elements;
    }

    resetErrors() {
        [...document.getElementsByClassName('error')].forEach(err => err.classList.remove('error'));
        this.errorcount = 0;
    }

    attachNewCompanyField() {
        const {company, newcompany} = this.elements;

        company.addEventListener('change', e =>
            e.target.value === 'other' ? newcompany.classList.add('active') : newcompany.classList.remove('active')
        );
    }

    addError(el) {
        this.errorcount++;
        el.classList.add('error');
    }

    hasErrors() {
        const {company, newcompany, report, peoplecheck} = this.elements;

        [company, report, peoplecheck].forEach(el => {
            if (!el.value) this.addError(el);
        });

        if (company.value && company.value === 'other' && !newcompany.value) this.addError(newcompany);

        if (!peoplecheck.value.trim().match(/^(4|vier|IV)$/)) this.addError(peoplecheck);

        return this.errorcount > 0;
    }

    submit() {
        this.resetErrors();

        const {company, newcompany, name, report, peoplecheck, submitbtn} = this.elements;

        submitbtn.disabled = 'disabled';

        if (this.hasErrors()) {
            submitbtn.removeAttribute('disabled');
            return false;
        }

        const formData = {
            company: company.value === 'other' ? newcompany.value : company.value,
            addcompany: company.value === 'other',
            name: name.value || 'anoniem',
            report: report.value.replace(/\n/g, '<br>')
        };

        request
            .post(document.location.href)
            .type('form')
            .send({
                ajax: true,
                request: 'postReport',
                data: JSON.stringify(formData)
            })
            .end((err, res) => {
                res = parseInt(res.text, 10);

                if (!isNaN(res) && res > 0) {
                    // success!
                    document.location.href = 'meldingen/' + res;
                } else {
                    window.alert('Er is iets fout gegaan bij het plaatsen. Probeer het later opnieuw');
                    submitbtn.removeAttribute('disabled');
                }
            });
    }
}

export default SubmitReport;
