
export default {
    data() {
        return {
            proscessLoading : null
        }
    },
    methods: {
      processLoad(type) {
          if (type ==  false) {
              this.proscessLoading.close();
          } else {
              this.proscessLoading =  this.$loading({
                  lock: true,
                  text: 'Loading',
                  background: 'rgba(0, 0, 0, 0.7)'
                  }) ;
          }
      },
      dateFormat(date) {
        var format = this.$moment(date).format("DD MMM YYYY")
        return format;
      },
       dateTimeFormat(date) {
        var format = this.$moment(date).format("DD MMM YYYY H:m:s")
        return format;
      },
      phoneFormat(row, column) {
        const phone = row[column.property];
        if (phone == 0) {
          return "-";
        } else {
          const format = `0${phone}`;
          return format;
        }
      },
      konvertMenit(data) {
        const menit = data / 60;
        const detik = data % 60;
        return Math.floor(menit) + " Menit " + Math.floor(detik) + " Detik ";
      },
  },
};
