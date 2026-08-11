<template>
  <div class="scroll-progress-bar" :style="{ width: progress + '%' }"></div>
</template>

<script setup>
defineProps({
  progress: {
    type: Number,
    default: 0,
  },
})
</script>

<style scoped>
.scroll-progress-bar {
  position: fixed;
  top: 0;
  left: 0;
  height: 3px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #06b6d4 100%);
  z-index: 9999;
  transition: width 0.1s linear;
  box-shadow: 0 0 12px rgba(102, 126, 234, 0.6);
}
</style>
