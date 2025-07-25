import { Component, ElementRef, EventEmitter, HostListener, Output, ViewChild } from '@angular/core';
import { FormsModule, NgModel } from '@angular/forms';
import { debounceTime, distinctUntilChanged, switchMap, Subject } from 'rxjs';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';
import { SearchService } from '../../services/search.service';

@Component({
  selector: 'app-search-bar',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './search-bar.component.html',
  styleUrl: './search-bar.component.scss'
})
export class SearchBarComponent {
  searchText = '';
  isTyping = false;
  suggestions: { id: number; label: string; type: 'event' | 'artist' | 'category' | 'hall' }[] = [];
  suggestionsVisible = false;

  // Subject to emit search input with debounce
  private searchSubject = new Subject<string>();

  @Output() search = new EventEmitter<string>();
  @ViewChild('container') containerRef!: ElementRef;

  // Subscribe to the subject, apply debounce and distinct check, then perform the API call
  constructor(private searchService: SearchService, private router: Router) {
    this.searchSubject.pipe(
      debounceTime(300),// Wait 300ms between keystrokes
      distinctUntilChanged(),// Ignore repeated inputs
      switchMap(query => this.searchService.search(query))// Cancel previous search if new one comes
    ).subscribe(results => {
      console.log("reusltat", results);
      this.suggestions = results;// Update suggestion list
      this.suggestionsVisible = true;
    });
  }

  @HostListener('document:click', ['$event'])
  onClickOutside(event: MouseEvent) {
    const clickedInside = this.containerRef.nativeElement.contains(event.target);
    if (!clickedInside) {
      this.suggestionsVisible = false;
    }
  }

  // Called when the user types in the input field
  onTyping(event: Event) {
    const input = event.target as HTMLInputElement;
    this.searchText = input.value;
    this.isTyping = input.value.trim() !== '';
    if (this.isTyping) {
      this.searchSubject.next(this.searchText);
    } else {
      this.suggestionsVisible = false;
      this.suggestions = [];
    }
  }

  onSearch() {
    this.search.emit(this.searchText);
    this.suggestionsVisible = false;
  }

  onDelete() {
    this.searchText = '';
    this.isTyping = false;
    this.suggestionsVisible = false;
    this.suggestions = [];
  }

  onSelect(item: any) {
    this.suggestionsVisible = false;
    this.searchText = '';
    this.isTyping = false;

    if (item.type === 'event') {
      this.router.navigate(['/concert', item.id]);
    } else if (item.type === 'artist') {
      this.router.navigate(['/artist', item.id]);
    } else if (item.type === 'category') {
      this.router.navigate(['/category', item.id]);
    } else if (item.type === 'hall') {
      this.router.navigate(['/hall', item.id]);
    }
  }
}
