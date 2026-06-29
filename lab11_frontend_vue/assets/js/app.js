const { createApp } = Vue;
const { createRouter, createWebHashHistory } = VueRouter;

// Tentukan lokasi API REST Endpoint
const apiUrl = 'http://localhost/lab11_backend_ci4/ci4/public';

// Definisikan mapping route ke komponen
const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/artikel',
        component: Artikel,
        meta: {
            requiresAuth: true
        }
    }
];

// Buat instance router
const router = createRouter({
    history: createWebHashHistory(),
    routes
});

// Navigation Guard (Proteksi Route)
router.beforeEach((to, from, next) => {
    const isAuthenticated =
        localStorage.getItem('isLoggedIn') === 'true';

    // Jika halaman membutuhkan login
    // dan user belum login
    if (
        to.matched.some(
            (record) => record.meta.requiresAuth
        ) &&
        !isAuthenticated
    ) {
        alert(
            'Akses Ditolak! Anda harus login terlebih dahulu.'
        );

        next('/login');
    } else {
        next();
    }
});

// Inisialisasi aplikasi Vue
const app = createApp({
    data() {
        return {
            isLoggedIn: false
        };
    },

    mounted() {
        // Cek status login saat aplikasi pertama dibuka
        this.isLoggedIn =
            localStorage.getItem('isLoggedIn') === 'true';
    },

    methods: {
        logout() {
            if (
                confirm(
                    'Apakah Anda yakin ingin keluar aplikasi?'
                )
            ) {
                localStorage.removeItem('isLoggedIn');
                localStorage.removeItem('userToken');

                this.isLoggedIn = false;

                this.$router.push('/');
            }
        }
    }
});

app.use(router);
app.mount('#app');