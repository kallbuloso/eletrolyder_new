const density = 'comfortable'
const variant = 'outlined'
export default {
  VNavigationDrawer: {
    color: 'background',
    floating: true,
    permanent: true
  },
  VAppBar: {
    color: 'background',
    app: true,
    elevation: 0,
    absolute: false
  },
  VFooter: {
    color: 'background',
    inset: true
  },
  IconBtn: {
    icon: true,
    VIcon: {
      size: 22
    }
  },
  VCard: {
    elevation: 3
  },
  VAlert: {
    density: `${density}`,
    VBtn: {
      color: undefined
    }
  },
  VAvatar: {
    // ℹ️ Remove after next release
    variant: 'flat'
  },

  VImg: {
    eager: true
  },
  VBadge: {
    // set v-badge default color to primary
    color: 'primary'
  },
  VBtn: {
    // set v-btn default color to primary
    color: 'primary',
    density: 'default',
    rounded: 'lg'
  },
  VChip: {
    size: 'small'
  },
  VMenu: {
    offset: '2px',
    density: `${density}`
  },
  VExpansionPanel: {
    density: `${density}`,
    expandIcon: 'mdi-chevron-down',
    collapseIcon: 'mdi-chevron-up'
  },
  VExpansionPanelTitle: {
    density: `${density}`,
    expandIcon: 'mdi-chevron-down',
    collapseIcon: 'mdi-chevron-up'
  },
  VList: {
    density: `${density}`,
    class: 'text-on-surface',
    VListItem: {
      density: `${density}`
    },
    VListItemGroup: {
      density: `${density}`
    },
    VCheckboxBtn: {
      density: `${density}`
    }
  },
  VPagination: {
    activeColor: 'primary',
    density: `${density}`,
    showFirstLastPage: true,
    variant: 'tonal',
    size: 'small',
    rounded: true
  },
  VTabs: {
    // set v-tabs default color to primary
    color: 'primary',
    density: `${density}`,
    VSlideGroup: {
      showArrows: true
    }
  },
  VBottomSheet: {
    inset: true
  },
  VTooltip: {
    color: 'background'
  },
  VCheckboxBtn: {
    color: 'primary'
  },
  VCheckbox: {
    // set v-checkbox default color to primary
    color: 'primary',
    density: `${density}`,
    hideDetails: 'auto'
  },
  VRadioGroup: {
    color: 'primary',
    density: `${density}`,
    hideDetails: 'auto'
  },
  VRadio: {
    density: `${density}`,
    hideDetails: 'auto'
  },
  VSelect: {
    variant: `${variant}`,
    color: 'primary',
    density: `${density}`,
    hideDetails: 'auto',
    VChip: {
      color: 'primary',
      label: true
    }
  },
  VRangeSlider: {
    // set v-range-slider default color to primary
    color: 'primary',
    trackColor: 'rgb(var(--v-theme-on-surface),0.06)',
    trackSize: 6,
    thumbSize: 7,
    density: `${density}`,
    thumbLabel: true,
    hideDetails: 'auto'
  },
  VRating: {
    // set v-rating default color to primary
    color: 'warning'
  },
  VProgressCircular: {
    // set v-progress-circular default color to primary
    color: 'primary'
  },
  VProgressLinear: {
    height: 12,
    roundedBar: true,
    rounded: true,
    color: 'primary'
  },
  VSlider: {
    // set v-slider default color to primary
    color: 'primary',
    trackColor: 'rgb(var(--v-theme-on-surface),0.06)',
    hideDetails: 'auto',
    thumbSize: 7,
    trackSize: 6
  },
  VTextField: {
    color: 'primary',
    variant: `${variant}`,
    density: `${density}`,
    hideDetails: 'auto'
  },
  VAutocomplete: {
    variant: `${variant}`,
    color: 'primary',
    density: `${density}`,
    hideDetails: 'auto',
    menuProps: {
      contentClass: ['app-inner-list', 'app-autocomplete__content', 'v-autocomplete__content']
    },
    VChip: {
      color: 'primary',
      label: true
    }
  },
  VCombobox: {
    variant: `${variant}`,
    density: `${density}`,
    color: 'primary',
    hideDetails: 'auto',
    VListItem: {
      color: 'error',
      density: 'compact'
    },
    VChip: {
      color: 'error',
      label: true
    }
  },
  VFileInput: {
    variant: `${variant}`,
    density: `${density}`,
    color: 'primary',
    hideDetails: 'auto'
  },
  VTextarea: {
    variant: `${variant}`,
    density: `${density}`,
    color: 'primary',
    hideDetails: 'auto'
  },
  VSwitch: {
    // set v-switch default color to primary
    inset: true,
    density: `${density}`,
    color: 'primary',
    hideDetails: 'auto'
  },
  VTimeline: {
    lineThickness: 1,
    density: `${density}`
  },
  VDataTableServer: {
    density: `${density}`
  },
  VDataTable: {
    VDataTableFooter: {
      VBtn: {
        density: `${density}`,
        color: 'primary'
      }
    }
  },
  VDatePicker: {
    color: 'primary',
    actions: {
      color: 'primary'
    }
  }
}
