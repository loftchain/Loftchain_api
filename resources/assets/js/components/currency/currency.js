import axios from 'axios';

export default {
    name: 'currency',
    components: {},
    props: [],
    data() {
        return {
            currencies: null,
            currentSort: 'id',
            currentSortDir: 'desc',
            pageSize: 10,
            currentPage: 1,
            totalPages: 1,
            isLoading: true,
        }
    },
    computed: {
        sortedItems: function () {
            if (this.currencies !== null) {
                return this.currencies.sort((a, b) => {
                    let modifier = 1;
                    if (this.currentSortDir === 'desc') modifier = -1;
                    if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                    if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                    return 0;
                }).filter((row, index) => {
                    let start = (this.currentPage - 1) * this.pageSize;
                    let end = this.currentPage * this.pageSize;
                    if (index >= start && index < end) return true;
                });
            }
        },
    },
    mounted() {
        this.getCurrencies();
    },
    methods: {
        async getCurrencies() {
            await axios.get('currencies/get')
                .then(res => {
                    this.isLoading = false;
                    const {data} = res;
                    this.totalPages = data.length;
                    this.currencies = data;
                })
        },

        sort: function (s) {
            if (s === this.currentSort) {
                this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
            }
            this.currentSort = s;
        },

        nextPage: function () {
            if ((this.currentPage * this.pageSize) < this.currencies.length) this.currentPage++;
        },

        prevPage: function () {
            if (this.currentPage > 1) this.currentPage--;
        },
    }
}
