<template>
  <div
    class="absolute w-auto right-3 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
  >
    <div class="p-menu" id="pv_id_4">
      <div class="p-menu-start">
        <slot name="header">
          <div class="flex flex-col align pl-6">
            <span class="font-bold text-blue-900">{{ title }}</span>
            <small class="text-blue-900">{{ subtitle }}</small>
          </div>
        </slot>
      </div>
      <div class="items">
        <slot name="items">
          <ul
            id="pv_id_4_list"
            class="p-menu-list p-reset"
            role="menu"
            tabindex="0"
          >
            <!--[--><!--[-->
            <li class="p-menuitem-separator" style="" role="separator"></li>

            <li
              id="pv_id_4_1"
              class="p-menuitem"
              role="menuitem"
              style=""
              aria-label="Profile"
              v-for="(item, index) in items"
              :key="index"
            >
              <div
                class="p-menuitem-content"
                :class="[isActive(item.url) ? 'active' : '']"
              >
                <!--[--><Link
                  :href="item.url"
                  class="p-menuitem-link"
                  tabindex="-1"
                  aria-hidden="true"
                >
                  <span
                    class="p-menuitem-icon"
                    :class="item.icon"
                    style="color: #183462 !important"
                  >
                  </span>
                  <span
                    class="p-menuitem-text"
                    style="color: #183462 !important"
                    >{{ item.label }}</span
                  >
                  <span
                    class="p-ink"
                    role="presentation"
                    aria-hidden="true"
                    style="
                      height: 173px;
                      width: 173px;
                      top: -78.6094px;
                      left: -32.5px;
                    "
                  >
                  </span>
                </Link>
              </div>
            </li>

            <li class="p-menuitem-separator" style="" role="separator"></li>
          </ul>
        </slot>
      </div>
      <div class="p-menu-end">
        <slot name="footer"> </slot>
      </div>
    </div>
  </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import { defineProps, defineEmits } from "vue";
const props = defineProps({
  title: {
    type: String,
    default: "Title",
  },
  subtitle: {
    type: String,
    default: "Subtitle",
  },
  items: {
    type: Array,
  },
});
const isActive = (url) => {
  if (url != "#") {
    return route().current()?.includes(url);
  }
  return false;
};
</script>
<style scoped>
.active {
  color: #495057;
  background: #e9ecef;
}
</style>
