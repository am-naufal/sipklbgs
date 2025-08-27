# Fix SQL Error: Unknown column 'nilai_akhir' in 'field list'

## Steps to Complete:

1. [x] Update KepalaSekolah/DashboardController.php index() method
    - Replace Penilaian::avg('nilai_akhir') with programmatic calculation
2. [x] Update KepalaSekolah/DashboardController.php penilaianOverview() method
    - Replace Penilaian::avg('nilai_akhir') with programmatic calculation
    - Replace Penilaian::max('nilai_akhir') with programmatic calculation
    - Replace Penilaian::min('nilai_akhir') with programmatic calculation
    - Update distribution query to work with calculated values
3. [x] Add missing relationship method penempatans() to Industri model
4. [x] Fix kepala sekolah sidebar navigation
    - Remove admin routes that cause 403 errors
    - Add proper kepala sekolah-specific routes
    - Remove duplicate navigation items
5. [ ] Test the changes to ensure they work correctly
