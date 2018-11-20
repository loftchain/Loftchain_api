import axios from 'axios';

export default {
    name: 'transaction',
    components: {},
    props: [],
    data() {
        return {
            transactions: null,
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
        sortedItems:function() {
            if(this.transactions !== null){
                return this.transactions.sort((a,b) => {
                    let modifier = 1;
                    if(this.currentSortDir === 'desc') modifier = -1;
                    if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                    if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                    return 0;
                }).filter((row, index) => {
                    let start = (this.currentPage-1)*this.pageSize;
                    let end = this.currentPage*this.pageSize;
                    if(index >= start && index < end) return true;
                }).filter((i) =>
                    this.checkedCurrency.includes(i.currency)
                );
            }
        },
    },
    mounted() {
        this.getTransactions()
    },
    methods: {
        async getTransactions() {
            await axios.get('transactions/get')
                .then(res => {
                    this.isLoading = false;
                    const {data} = res;
                    this.totalPages = data.length;
                    this.transactions = data;
                })
        },

        sort: function (s) {
            if (s === this.currentSort) {
                this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
            }
            this.currentSort = s;
        },

        nextPage: function () {
            if ((this.currentPage * this.pageSize) < this.transactions.length) this.currentPage++;
        },

        prevPage: function () {
            if (this.currentPage > 1) this.currentPage--;
        },

        checkBoxClick: function () {
            this.pageSize = this.totalPages;
        },

    }
}
