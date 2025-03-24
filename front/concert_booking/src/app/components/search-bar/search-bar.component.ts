import { Component, EventEmitter, Output } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-search-bar',
  standalone: true,
  imports: [
    FormsModule,
  ],
  templateUrl: './search-bar.component.html',
  styleUrl: './search-bar.component.scss'
})
export class SearchBarComponent {

  searchText: string = "";
  isTyping: boolean = false;

  @Output() search = new EventEmitter<string>();

  onSearch() {
    this.search.emit(this.searchText);
  }

  onTyping(event: Event) {
    const input = event.target as HTMLInputElement;
    if (input.value.trim() === '') {
      this.isTyping = false;
    } else {
      this.isTyping = true;
    }
  }

  onDelete() {
    this.searchText="";
    this.isTyping = false;
  }
}
