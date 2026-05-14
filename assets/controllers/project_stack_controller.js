import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ['frontendTags', 'backendTags', 'toolsTags', 'output']

    connect() {
        this.skills = this.parseOutputValue(this.outputTarget.value)
        this.render()
    }

    addFromSelect(event) {
        const value = String(event.currentTarget.value || '').trim()
        const category = String(event.currentTarget.dataset.category || '')
        if (!value) {
            return
        }

        if (!this.isCategory(category)) {
            event.currentTarget.value = ''
            return
        }

        if (!this.skills[category].includes(value)) {
            this.skills[category].push(value)
            this.render()
        }

        event.currentTarget.value = ''
    }

    remove(event) {
        const index = parseInt(event.currentTarget.dataset.index || '-1', 10)
        const category = String(event.currentTarget.dataset.category || '')
        if (!this.isCategory(category) || index < 0 || index >= this.skills[category].length) {
            return
        }

        this.skills[category].splice(index, 1)
        this.render()
    }

    render() {
        this.renderCategory('frontend', this.frontendTagsTarget)
        this.renderCategory('backend', this.backendTagsTarget)
        this.renderCategory('tools', this.toolsTagsTarget)

        this.outputTarget.value = JSON.stringify(this.skills)
    }

    parseOutputValue(value) {
        const empty = { frontend: [], backend: [], tools: [] }

        if (typeof value !== 'string' || value.trim() === '') {
            return empty
        }

        try {
            const parsed = JSON.parse(value)
            if (!parsed || typeof parsed !== 'object') {
                return empty
            }

            return {
                frontend: this.sanitizeValues(parsed.frontend),
                backend: this.sanitizeValues(parsed.backend),
                tools: this.sanitizeValues(parsed.tools),
            }
        } catch {
            const legacy = this.sanitizeValues(value.split(','))
            return {
                frontend: [],
                backend: [],
                tools: legacy,
            }
        }
    }

    renderCategory(category, container) {
        container.innerHTML = ''

        if (this.skills[category].length === 0) {
            const empty = document.createElement('span')
            empty.className = 'skill-tags-empty'
            empty.textContent = 'Aucune techno'
            container.appendChild(empty)
            return
        }

        this.skills[category].forEach((skill, index) => {
            const tag = document.createElement('div')
            tag.className = 'skill-tag'

            const label = document.createElement('span')
            label.textContent = skill
            tag.appendChild(label)

            const removeButton = document.createElement('button')
            removeButton.type = 'button'
            removeButton.className = 'skill-tag-remove'
            removeButton.dataset.action = 'project-stack#remove'
            removeButton.dataset.category = category
            removeButton.dataset.index = String(index)
            removeButton.setAttribute('aria-label', `Supprimer ${skill}`)
            removeButton.textContent = 'x'
            tag.appendChild(removeButton)

            container.appendChild(tag)
        })
    }

    sanitizeValues(values) {
        if (!Array.isArray(values)) {
            return []
        }

        return [...new Set(values.map((value) => String(value).trim()).filter((value) => value !== ''))]
    }

    isCategory(category) {
        return ['frontend', 'backend', 'tools'].includes(category)
    }
}
