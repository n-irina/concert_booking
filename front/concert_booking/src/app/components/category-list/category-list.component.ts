import { Component, OnInit } from '@angular/core';
import { GetCategoriesService } from '../../services/get-categories.service';
import { Category } from '../../models/category.model';

@Component({
  selector: 'app-category-list',
  standalone: true,
  imports: [],
  templateUrl: './category-list.component.html',
  styleUrl: './category-list.component.scss'
})
export class CategoryListComponent implements OnInit {

  categories: Category[] = [];

  constructor(private categoryService: GetCategoriesService) { }

  ngOnInit(): void {
    this.categoryService.getCategories().subscribe(res => this.categories = res["member"]);
  }
}