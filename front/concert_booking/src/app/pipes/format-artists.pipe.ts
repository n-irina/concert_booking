import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'formatArtists',
  standalone: true // si tu es en standalone
})
export class FormatArtistsPipe implements PipeTransform {
  transform(artists: { nickname: string }[] | null | undefined): string {
    if (!artists || artists.length === 0) return '';

    const names = artists.map(a => a.nickname);

    if (names.length === 1) {
      return names[0];
    }

    if (names.length === 2) {
      return `${names[0]} & ${names[1]}`;
    }

    const allButLast = names.slice(0, -1).join(', ');
    const last = names[names.length - 1];
    return `${allButLast} & ${last}`;
  }
}
