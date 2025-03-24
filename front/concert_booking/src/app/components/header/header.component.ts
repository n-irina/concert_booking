import { Component } from '@angular/core';
import { SearchBarComponent } from '../search-bar/search-bar.component';

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [
    SearchBarComponent,
  ],
  templateUrl: './header.component.html',
  styleUrl: './header.component.scss'
})
export class HeaderComponent {

  onSearch(query: string) {
    console.log('Recherche :', query);
    // → Appel à ton service / filtre local / route, etc.
  }

}
