import axios from 'axios';

export default {
    name: 'customer',
    components: {},
    props: [],
    data() {
        return {
            customers: null,
            currentSort: 'date',
            currentSortDir: 'desc',
            pageSize: 10,
            currentPage: 1,
            totalPages: 1,
            checkedCurrency: ['BTC', 'ETH'],
            isLoading: true,
        }
    },
    computed: {
        sortedItems: function () {
            if (this.customers !== null) {
                return this.customers.sort((a, b) => {
                    let modifier = 1;
                    if (this.currentSortDir === 'desc') modifier = -1;
                    if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                    if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                    return 0;
                }).filter((row, index) => {
                    let start = (this.currentPage - 1) * this.pageSize;
                    let end = this.currentPage * this.pageSize;
                    if (index >= start && index < end) return true;
                }).filter((i) =>
                    this.checkedCurrency.includes(i.wallet_currency)
                );
            }
        },
    },
    mounted() {
        this.getCustomers();
    },
    methods: {
        async getCustomers(){
            await axios.get('customer/get')
                .then(res => {
                    this.isLoading = false;
                    const {data} = res;
                    this.totalPages = data.length;
                    this.customers = data;
                })
        },

        sort: function (s) {
            if (s === this.currentSort) {
                this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
            }
            this.currentSort = s;
        },

        nextPage: function () {
            if ((this.currentPage * this.pageSize) < this.customers.length) this.currentPage++;
        },

        prevPage: function () {
            if (this.currentPage > 1) this.currentPage--;
        },

        checkBoxClick: function () {
            this.pageSize = this.totalPages;
        },
    }
}
