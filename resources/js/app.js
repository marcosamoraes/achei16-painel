import './bootstrap'

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import PerfectScrollbar from 'perfect-scrollbar'
import mask from '@alpinejs/mask'
import Chart from 'chart.js/auto'

Alpine.plugin(mask)

import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

window.PerfectScrollbar = PerfectScrollbar

document.addEventListener('alpine:init', () => {
    Alpine.data('mainState', () => {
        let lastScrollTop = 0
        const init = function () {
            window.addEventListener('scroll', () => {
                let st =
                    window.pageYOffset || document.documentElement.scrollTop
                if (st > lastScrollTop) {
                    // downscroll
                    this.scrollingDown = true
                    this.scrollingUp = false
                } else {
                    // upscroll
                    this.scrollingDown = false
                    this.scrollingUp = true
                    if (st == 0) {
                        //  reset
                        this.scrollingDown = false
                        this.scrollingUp = false
                    }
                }
                lastScrollTop = st <= 0 ? 0 : st // For Mobile or negative scrolling
            })
        }

        const getTheme = () => {
            if (window.localStorage.getItem('dark')) {
                return JSON.parse(window.localStorage.getItem('dark'))
            }
            return (
                !!window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
            )
        }

        const setTheme = (value) => {
            window.localStorage.setItem('dark', value)
        }

        const phoneMask = (input) => {
            return input.length <= 14
                ? '(99) 9999-9999'
                : '(99) 99999-9999';
        }

        const cpfCnpjMask = (input) => {
            return input.length <= 14
                ? '999.999.999-99'
                : '99.999.999/9999-99';
        }

        const imageViewer = () => {
            return {
                imageUrl: $('[name="image_url"]').val() || '',

                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },

                fileToDataUrl(event, callback) {
                    if (! event.target.files.length) return

                    let file = event.target.files[0],
                        reader = new FileReader()

                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },
            }
        }

        const imagesViewer = () => {
            return {
                imagesUrl: $('[name="images_url[]"').val() ? $('[name="images_url[]"').val().split(',') : '',

                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imagesUrl = src)
                },

                fileToDataUrl(event, callback) {
                    if (!event.target.files.length) return;

                    let files = event.target.files;
                    let results = [];

                    for (let i = 0; i < files.length; i++) {
                        let file = files[i];
                        let reader = new FileReader();

                        reader.readAsDataURL(file);
                        reader.onload = e => {
                            results.push(e.target.result);

                            if (results.length === files.length) {
                                callback(results);
                            }
                        };
                    }
                },
            }
        }

        return {
            init,
            isDarkMode: getTheme(),
            toggleTheme() {
                this.isDarkMode = !this.isDarkMode
                setTheme(this.isDarkMode)
            },
            isSidebarOpen: window.innerWidth > 1024,
            isSidebarHovered: false,
            handleSidebarHover(value) {
                if (window.innerWidth < 1024) {
                    return
                }
                this.isSidebarHovered = value
            },
            handleWindowResize() {
                if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false
                } else {
                    this.isSidebarOpen = true
                }
            },
            scrollingDown: false,
            scrollingUp: false,
            phoneMask,
            cpfCnpjMask,
            imageViewer,
            imagesViewer,

            cep: document.getElementById('cep')?.value || '',
            address: document.getElementById('address')?.value || '',
            number: document.getElementById('number')?.value || '',
            complement: document.getElementById('complement')?.value || '',
            neighborhood: document.getElementById('neighborhood')?.value || '',
            city: document.getElementById('city')?.value || '',
            state: document.getElementById('state')?.value || '',
            async getAddressByCep() {
                if (this.cep.length <= 8) return
                this.toggleCep()
                const response = await fetch(this.urlApi(this.cep))
                const data = await response.json()

                this.number = ''
                this.complement = ''

                this.address = data.logradouro
                this.neighborhood = data.bairro
                this.city = data.localidade
                this.state = data.uf
                this.toggleCep()
            },
            urlApi(cep) {
                return `https://viacep.com.br/ws/${cep}/json/`
            },
            toggleCep() {
                this.$refs.cep.disabled
                    ? this.$refs.cep.removeAttribute('disabled')
                    : this.$refs.cep.setAttribute('disabled', true)
            },
        }
    })
})

Alpine.plugin(collapse)

Alpine.start()

$(document).ready(function() {
    // Select2 Multiple
    $('.select2, .select2-multiple').select2({
        placeholder: "Selecione...",
        allowClear: true
    });
});

window.Chart = Chart;

$(".chart").each(function () {
    let type = $(this).data("type");
    let labels = $(this).data("labels");
    let series = $(this).data("series");
    let options = $(this).data("options");
    let ctx = this.getContext("2d");

    new Chart(ctx, {
        type: type,
        data: {
            labels: labels,
            datasets: [
                {
                    label: labels,
                    data: series,
                },
            ],
        },
        options: options,
    });
});
