import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ['tags', 'labelInput', 'iconInput', 'output']
    static values = { skills: Array }

    connect() {
        this.skills = [...this.skillsValue]
        this.render()
    }

    add() {
        const label = this.labelInputTarget.value.trim()
        const icon = this.iconInputTarget.value.trim()
        if (!label) return

        this.skills.push({ label, icon })
        this.labelInputTarget.value = ''
        this.iconInputTarget.value = ''
        this.labelInputTarget.focus()
        this.render()
    }

    remove(event) {
        const index = parseInt(event.currentTarget.dataset.index, 10)
        this.skills.splice(index, 1)
        this.render()
    }

    addOnEnter(event) {
        if (event.key === 'Enter') {
            event.preventDefault()
            this.add()
        }
    }

    render() {
        this.tagsTarget.innerHTML = ''

        if (this.skills.length === 0) {
            const empty = document.createElement('span')
            empty.className = 'skill-tags-empty'
            empty.textContent = 'Aucune compétence'
            this.tagsTarget.appendChild(empty)
            this.outputTarget.value = '[]'
            return
        }

        this.skills.forEach((skill, i) => {
            const tag = document.createElement('div')
            tag.className = 'skill-tag'

            if (skill.icon) {
                const icon = document.createElement('i')
                icon.className = skill.icon
                tag.appendChild(icon)
            }

            const label = document.createElement('span')
            label.textContent = skill.label
            tag.appendChild(label)

            const btn = document.createElement('button')
            btn.type = 'button'
            btn.className = 'skill-tag-remove'
            btn.dataset.action = 'skill-list#remove'
            btn.dataset.index = String(i)
            btn.setAttribute('aria-label', `Supprimer ${skill.label}`)
            btn.textContent = '×'
            tag.appendChild(btn)

            this.tagsTarget.appendChild(tag)
        })

        this.outputTarget.value = JSON.stringify(this.skills)
    }
}
