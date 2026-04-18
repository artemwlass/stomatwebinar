const bodyHidden = () => {
    document.querySelector('body').style.overflow = 'hidden';
}

const bodyVisible = () => {
    document.querySelector('body').style.overflow = 'visible';
}

const phoneInp = document.querySelectorAll('input[type="tel"]');

if (phoneInp.length) {
    phoneInp.forEach(el => {
        IMask(el, {
            mask: '+{7}(000) 000-00-00',
        })
    });
}

document.querySelectorAll('.form-date__inp').forEach(wrapper => {
    const inputs = wrapper.querySelectorAll('input');

    const configs = [
        { from: 1, to: 31 },
        { from: 1, to: 12 },
        { from: 1900, to: 9999 }
    ];

    inputs.forEach((inp, i) => {
        IMask(inp, {
            mask: IMask.MaskedRange,
            from: configs[i].from,
            to: configs[i].to,
            maxLength: inp.maxLength,
            autofix: true
        });

        inp.addEventListener('input', () => {
            if (inp.value.length === inp.maxLength && inputs[i + 1]) {
                inputs[i + 1].focus();
            }
        });

        inp.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !inp.value && inputs[i - 1]) {
                inputs[i - 1].focus();
            }
        });
    });
});

const dashboardBtn = document.querySelector('.dashboard-btn');
const dashboardLeft = document.querySelector('.dashboard-left');

if (dashboardBtn) {
    dashboardBtn.addEventListener('click', () => {
        dashboardBtn.classList.toggle('active');
        dashboardLeft.style.maxHeight = dashboardLeft.style.maxHeight ? null : dashboardLeft.scrollHeight + 'px';
    });
}

const modalClasses = ['.certificate-modal', '.data-modal'];
modalClasses.forEach(cls => {
    const m = document.querySelector(cls);
    const mOpenBtns = document.querySelectorAll(cls + '__open');
    const mBg = document.querySelector(cls + ' .modal-bg');
    const mCloseBtn = document.querySelector(cls + ' .modal-close');

    if (m) {
        mOpenBtns.forEach(btn => {
            btn.onclick = e => {
                e.preventDefault();
                m.classList.add('active');
                bodyHidden();
            }
        })
    
        mBg.onclick = () => {
            m.classList.remove('active');
            bodyVisible();
        }
    
        mCloseBtn.onclick = () => {
            m.classList.remove('active');
            bodyVisible();
        }
    }
})

const certificateTabBtns = document.querySelectorAll('.certificate .tab-head button');
const certificateTabBody = document.querySelectorAll('.certificate .tab-body');

if (certificateTabBtns.length) {
    certificateTabBtns.forEach((btn, btnIdx) => {
        btn.onclick = () => {
            certificateTabBtns.forEach((el, elIdx) => {
                if (elIdx == btnIdx) {
                    el.classList.add('active');
                } else {
                    el.classList.remove('active');
                }
            })
            certificateTabBody.forEach((el, elIdx) => {
                if (elIdx == btnIdx) {
                    el.classList.add('active');
                } else {
                    el.classList.remove('active');
                }
            })
        }
    })
} 