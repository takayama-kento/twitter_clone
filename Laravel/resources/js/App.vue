<template>
    <div>
        <header>
            <Navbar />
        </header>
        <main>
            <div class="container">
                <RouterView />
            </div>
        </main>
        <footer>
            <Footer />
        </footer>
    </div>
</template>

<script>
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'

export default {
    components: {
        Navbar,
        Footer,
    }
}
</script>