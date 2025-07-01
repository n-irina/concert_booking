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

    // Remove duplicates by name
    const uniqueCategories = categories.filter((category, index, self) =>
      index === self.findIndex(c => c.name === category.name)
    );

    return uniqueCategories.map(category => category.name).join(', ');
  }

}
