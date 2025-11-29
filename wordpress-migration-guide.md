# WordPress Migration Guide (Hindi/English)

## WordPress Site Migration - Complete Procedure

### Method 1: Manual Migration (Best for Full Control)

#### Step 1: Backup Old Site
```bash
# Files backup
tar -czf wordpress-backup-$(date +%Y%m%d).tar.gz /path/to/wordpress/

# Database backup
mysqldump -u username -p database_name > wordpress-db-$(date +%Y%m%d).sql
```

**Ya phpMyAdmin se:**
- Database select karein
- Export tab click karein
- SQL format select karein
- Go button click karein

#### Step 2: New Server Setup
1. WordPress install karein (same version)
2. New database create karein
3. `wp-config.php` me database credentials update karein

#### Step 3: Files Transfer
```bash
# Important folders/files to copy:
- wp-content/themes/     (All themes)
- wp-content/plugins/    (All plugins)
- wp-content/uploads/    (All media files)
- wp-config.php          (Update database credentials)
```

**Permissions set karein:**
```bash
find /path/to/wordpress -type d -exec chmod 755 {} \;
find /path/to/wordpress -type f -exec chmod 644 {} \;
```

#### Step 4: Database Import
```bash
# Command line se:
mysql -u username -p new_database_name < wordpress-db-backup.sql

# Ya phpMyAdmin se:
- New database select karein
- Import tab click karein
- SQL file select karein
- Go button click karein
```

#### Step 5: URLs Update (Very Important!)
Database me old URLs ko new URLs se replace karna zaroori hai.

**Option A: WP-CLI se (Best)**
```bash
wp search-replace 'old-site.com' 'new-site.com' --allow-root
wp search-replace 'http://old-site.com' 'https://new-site.com' --allow-root
```

**Option B: Search Replace DB Tool**
- https://github.com/interconnectit/Search-Replace-DB download karein
- Upload karein new server par
- Old URL aur new URL enter karein
- Replace execute karein

**Option C: SQL Query se**
```sql
UPDATE wp_options SET option_value = replace(option_value, 'http://old-site.com', 'http://new-site.com');
UPDATE wp_posts SET post_content = replace(post_content, 'http://old-site.com', 'http://new-site.com');
UPDATE wp_posts SET guid = replace(guid, 'http://old-site.com', 'http://new-site.com');
```

#### Step 6: Final Checks
1. `.htaccess` file check karein
2. Permalinks settings update karein (Settings > Permalinks > Save)
3. Cache clear karein
4. SSL certificate setup (agar https use kar rahe ho)

---

### Method 2: Plugin Use Karke (Easier Method)

#### All-in-One WP Migration Plugin:
1. Old site par plugin install karein
2. Export > Export to File
3. Export file download karein
4. New site par WordPress install karein
5. Same plugin install karein
6. Import > Import from File
7. Upload export file
8. Import complete hone tak wait karein

#### Duplicator Plugin:
1. Old site par Duplicator install karein
2. Package create karein (files + database)
3. Installer aur Archive file download karein
4. New server par dono files upload karein
5. Installer file browser me open karein
6. Step-by-step wizard follow karein

---

### Important Points:

✅ **Theme aur Layout Same Rahega:**
- Agar aapne `wp-content/themes/` folder properly copy kiya hai
- Aur database me theme settings properly migrate hui hain
- To theme, layout, sab kuch same rahega

⚠️ **Common Issues:**
- URLs properly update nahi hui → Site broken links dikhayega
- Permissions wrong → Files access nahi honge
- Database credentials wrong → Site connect nahi hogi
- Missing files → Images/plugins kaam nahi karenge

🔧 **Quick Fixes:**
```bash
# Permalinks reset
wp rewrite flush --allow-root

# Cache clear
wp cache flush --allow-root

# Check database connection
wp db check --allow-root
```

---

### Pre-Migration Checklist:
- [ ] Old site ka complete backup liya
- [ ] Database backup liya
- [ ] New server par WordPress install kiya
- [ ] New database create kiya
- [ ] wp-config.php me credentials update kiye
- [ ] Files properly transfer kiye
- [ ] Database import kiya
- [ ] URLs update kiye
- [ ] Permalinks reset kiye
- [ ] Cache clear kiya
- [ ] Site test kiya

---

### Post-Migration Checklist:
- [ ] Homepage properly load ho raha hai
- [ ] All pages accessible hain
- [ ] Images properly load ho rahe hain
- [ ] Plugins kaam kar rahe hain
- [ ] Theme properly display ho raha hai
- [ ] Forms/contact pages kaam kar rahe hain
- [ ] Admin panel accessible hai
- [ ] SSL certificate properly configured hai (agar https use kar rahe ho)

---

### Useful Commands (WP-CLI):

```bash
# Site URL check
wp option get siteurl
wp option get home

# URLs update
wp search-replace 'old-url' 'new-url' --allow-root --dry-run  # Test first
wp search-replace 'old-url' 'new-url' --allow-root            # Actual replace

# Database check
wp db check --allow-root

# Cache clear
wp cache flush --allow-root

# Permalinks reset
wp rewrite flush --allow-root
```

---

**Note:** Migration se pehle hamesha complete backup lein. Agar koi issue aaye to backup se restore kar sakte hain.









































