import { Pipe, PipeTransform } from '@angular/core';
import { Category } from '../models/category.model';

@Pipe({
  name: 'formatCategories',
  standalone: true
})
export class FormatCategoriesPipe implements PipeTransform {

  transform(categories: Category[] | null | undefined): string {
    if (!categories || categories.length === 0) {
      return '';
    }

    // Dédoublonner par nom
    const unique = Array.from(new Map(categories.map(c => [c.name, c])).values());

    return unique.map(c => c.name).join(' - ');
  }

}
