import { Injectable } from '@angular/core';
import { Category } from '../models/category.model';
import { Hall } from '../models/hall.model';

@Injectable({
  providedIn: 'root'
})
export class EventSharedService {

  private _categories: Category[] = [];

  setCategories(categories: Category[]) {
    this._categories = categories;
  }

  getCategories(): Category[] {
    return this._categories;
  }

}
