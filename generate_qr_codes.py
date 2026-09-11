import os
import qrcode
from PIL import Image, ImageDraw, ImageFont

OUTPUT_DIR = os.path.join(os.path.dirname(__file__), "assets", "images", "qr-codes")
os.makedirs(OUTPUT_DIR, exist_ok=True)

# Brand Colors
COLOR_PRIMARY = (16, 55, 85)     # Deep Stridewel Navy (#103755)
COLOR_RED = (237, 28, 36)        # Stridewel Vibrant Red (#ed1c24)
COLOR_DARK = (15, 23, 42)        # Slate Dark (#0f172a)
COLOR_MUTED = (100, 116, 139)    # Slate 500 (#64748b)
COLOR_BG = (248, 250, 252)       # Soft Slate White (#f8fafc)
COLOR_CARD_BG = (255, 255, 255)
COLOR_BORDER = (226, 232, 240)   # Slate 200

# Fonts
def get_font(size, bold=False):
    font_names = ["segoeuib.ttf", "arialbd.ttf"] if bold else ["segoeui.ttf", "arial.ttf"]
    for name in font_names:
        p = os.path.join("C:/Windows/Fonts", name)
        if os.path.exists(p):
            try:
                return ImageFont.truetype(p, size)
            except Exception:
                pass
    return ImageFont.load_default()

def draw_rounded_rect(draw, bounds, radius, fill, outline=None, width=1):
    draw.rounded_rectangle(bounds, radius=radius, fill=fill, outline=outline, width=width)

def generate_base_qr(url, color_dark=COLOR_PRIMARY, bg_color=(255, 255, 255), box_size=16):
    qr = qrcode.QRCode(
        version=None,
        error_correction=qrcode.constants.ERROR_CORRECT_H,
        box_size=box_size,
        border=3,
    )
    qr.add_data(url)
    qr.make(fit=True)
    img = qr.make_image(fill_color=color_dark, back_color=bg_color).convert("RGBA")
    return img

def add_center_icon(qr_img, icon_type="catalogue"):
    w, h = qr_img.size
    icon_box_size = int(w * 0.22)
    center_box = Image.new("RGBA", (icon_box_size, icon_box_size), (0, 0, 0, 0))
    cdraw = ImageDraw.Draw(center_box)
    
    # Rounded white background with red border
    cdraw.rounded_rectangle(
        [2, 2, icon_box_size - 2, icon_box_size - 2],
        radius=int(icon_box_size * 0.26),
        fill=(255, 255, 255, 255),
        outline=COLOR_RED,
        width=int(icon_box_size * 0.04)
    )
    
    font_bold = get_font(int(icon_box_size * 0.38), bold=True)
    text = "PDF" if icon_type == "catalogue" else "RFQ"
    tb = cdraw.textbbox((0, 0), text, font=font_bold)
    tw = tb[2] - tb[0]
    th = tb[3] - tb[1]
    cdraw.text(
        ((icon_box_size - tw) // 2, (icon_box_size - th) // 2 - int(icon_box_size * 0.03)),
        text,
        fill=COLOR_RED,
        font=font_bold
    )
    
    pos = ((w - icon_box_size) // 2, (h - icon_box_size) // 2)
    qr_img.paste(center_box, pos, center_box)
    return qr_img

def build_presentation_card(
    qr_img,
    pre_title,
    main_title,
    sub_title,
    bottom_cta,
    url_display,
    badge_text="ISO 9001:2015",
    footer_text=""
):
    CARD_W = 1000
    CARD_H = 1360
    card = Image.new("RGBA", (CARD_W, CARD_H), (255, 255, 255, 255))
    draw = ImageDraw.Draw(card)
    
    # Outer Card Border with subtle rounded corner
    draw_rounded_rect(draw, [0, 0, CARD_W - 1, CARD_H - 1], radius=32, fill=None, outline=COLOR_BORDER, width=2)
    
    # 1. Top Header Banner
    HEADER_H = 120
    draw.rounded_rectangle([0, 0, CARD_W, HEADER_H], radius=32, fill=COLOR_PRIMARY)
    draw.rectangle([0, 60, CARD_W, HEADER_H], fill=COLOR_PRIMARY) # flatten bottom corners
    
    font_brand = get_font(34, bold=True)
    draw.text((40, 28), "STRIDEWEL INTERNATIONAL", fill=(255, 255, 255), font=font_brand)
    
    font_tagline = get_font(16, bold=False)
    draw.text((40, 72), "PRECISION VETERINARY & ARTIFICIAL INSEMINATION EQUIPMENT", fill=(203, 213, 225), font=font_tagline)
    
    # Top Right ISO / OEM Badge
    badge_font = get_font(18, bold=True)
    tb = draw.textbbox((0, 0), badge_text, font=badge_font)
    bw = tb[2] - tb[0] + 28
    bh = 40
    bx = CARD_W - bw - 40
    by = 40
    draw_rounded_rect(draw, [bx, by, bx + bw, by + bh], radius=20, fill=COLOR_RED)
    draw.text((bx + 14, by + 9), badge_text, fill=(255, 255, 255), font=badge_font)
    
    # 2. Main Title Section
    font_pre = get_font(20, bold=True)
    draw.text((60, 165), pre_title.upper(), fill=COLOR_RED, font=font_pre)
    
    font_title = get_font(42, bold=True)
    draw.text((60, 198), main_title, fill=COLOR_PRIMARY, font=font_title)
    
    font_sub = get_font(22, bold=False)
    draw.text((60, 254), sub_title, fill=COLOR_MUTED, font=font_sub)
    
    # 3. QR Code Framing
    FRAME_SIZE = 610
    FX = (CARD_W - FRAME_SIZE) // 2
    FY = 310
    
    # Soft inner background container
    draw_rounded_rect(draw, [FX, FY, FX + FRAME_SIZE, FY + FRAME_SIZE], radius=28, fill=(255, 255, 255), outline=COLOR_RED, width=3)
    
    # Resize QR to fit frame with clean margin
    QR_TARGET_SIZE = 550
    resized_qr = qr_img.resize((QR_TARGET_SIZE, QR_TARGET_SIZE), Image.Resampling.LANCZOS)
    QR_X = (CARD_W - QR_TARGET_SIZE) // 2
    QR_Y = FY + (FRAME_SIZE - QR_TARGET_SIZE) // 2
    card.paste(resized_qr, (QR_X, QR_Y), resized_qr)
    
    # 4. Bottom Call To Action
    font_cta = get_font(26, bold=True)
    tb_cta = draw.textbbox((0, 0), bottom_cta, font=font_cta)
    cta_w = tb_cta[2] - tb_cta[0]
    draw.text(((CARD_W - cta_w) // 2, 955), bottom_cta, fill=COLOR_PRIMARY, font=font_cta)
    
    # Web URL Pill
    font_url = get_font(24, bold=True)
    tb_u = draw.textbbox((0, 0), url_display, font=font_url)
    uw = tb_u[2] - tb_u[0] + 50
    uh = 48
    ux = (CARD_W - uw) // 2
    uy = 998
    draw_rounded_rect(draw, [ux, uy, ux + uw, uy + uh], radius=24, fill=(241, 245, 249))
    draw.text(((CARD_W - (tb_u[2] - tb_u[0])) // 2, uy + 10), url_display, fill=COLOR_RED, font=font_url)
    
    # Decorative divider
    draw.line([60, 1220, CARD_W - 60, 1220], fill=(226, 232, 240), width=2)
    
    # 5. Footer Information
    font_foot = get_font(18, bold=False)
    tb_f = draw.textbbox((0, 0), footer_text, font=font_foot)
    fw = tb_f[2] - tb_f[0]
    draw.text(((CARD_W - fw) // 2, 1245), footer_text, fill=COLOR_MUTED, font=font_foot)
    
    return card

def main():
    print("Generating High-Resolution Stridewel QR Codes with correct British/Indian spelling 'CATALOGUE'...")
    
    # 1. CATALOGUE DOWNLOAD QR CODE
    catalogue_url = "https://stridewel.com/catalogue"
    qr_catalogue = generate_base_qr(catalogue_url, color_dark=COLOR_PRIMARY, box_size=20)
    qr_catalogue = add_center_icon(qr_catalogue, icon_type="catalogue")
    
    # Save standalone clean QR
    clean_cat_path = os.path.join(OUTPUT_DIR, "qr_catalogue_clean.png")
    qr_catalogue.save(clean_cat_path, "PNG", dpi=(300, 300))
    # Keep legacy catalog filename as alias
    qr_catalogue.save(os.path.join(OUTPUT_DIR, "qr_catalog_clean.png"), "PNG", dpi=(300, 300))
    print(f"Saved: {clean_cat_path}")
    
    # Build Catalogue Presentation Card
    card_catalogue = build_presentation_card(
        qr_img=qr_catalogue,
        pre_title="Official Catalogue Download",
        main_title="SCAN TO DOWNLOAD CATALOGUE",
        sub_title="Instant access to 36+ Veterinary & A.I. Instruments (PDF)",
        bottom_cta="Scan with Camera to Open Catalogue",
        url_display="stridewel.com/catalogue",
        badge_text="ISO 9001:2015",
        footer_text="36+ A.I. Instruments • Institutional Tenders • Export Inquiries: stridewel@gmail.com"
    )
    card_cat_path = os.path.join(OUTPUT_DIR, "qr_catalogue_badge.png")
    card_catalogue.save(card_cat_path, "PNG", dpi=(300, 300))
    # Also update qr_catalog_badge.png with the corrected spelling
    card_catalogue.save(os.path.join(OUTPUT_DIR, "qr_catalog_badge.png"), "PNG", dpi=(300, 300))
    print(f"Saved: {card_cat_path}")
    
    # 2. CONTACT / INQUIRY FORM QR CODE
    contact_url = "https://stridewel.com/contact"
    qr_contact = generate_base_qr(contact_url, color_dark=COLOR_PRIMARY, box_size=20)
    qr_contact = add_center_icon(qr_contact, icon_type="contact")
    
    # Save standalone clean Contact QR
    clean_contact_path = os.path.join(OUTPUT_DIR, "qr_contact_clean.png")
    qr_contact.save(clean_contact_path, "PNG", dpi=(300, 300))
    print(f"Saved: {clean_contact_path}")
    
    # Build Contact Presentation Card
    card_contact = build_presentation_card(
        qr_img=qr_contact,
        pre_title="Direct Factory Inquiries",
        main_title="SCAN TO SUBMIT YOUR INQUIRY",
        sub_title="Quick mobile RFQ, price quotes & institutional tenders",
        bottom_cta="Scan with Camera to Fill Inquiry Form",
        url_display="stridewel.com/contact",
        badge_text="OEM DIRECT",
        footer_text="Instant Quotations • 24/7 WhatsApp Support: +91 98100 46038 • Make In India"
    )
    card_contact_path = os.path.join(OUTPUT_DIR, "qr_contact_badge.png")
    card_contact.save(card_contact_path, "PNG", dpi=(300, 300))
    print(f"Saved: {card_contact_path}")
    
    # 3. COMBINED PRESENTATION BANNER (Both side-by-side)
    COMB_W = 2160
    COMB_H = 1520
    combined = Image.new("RGBA", (COMB_W, COMB_H), COLOR_BG)
    cdraw = ImageDraw.Draw(combined)
    
    font_main_h = get_font(46, bold=True)
    top_title = "STRIDEWEL INTERNATIONAL • OFFICIAL MOBILE QR CODES"
    tb_m = cdraw.textbbox((0, 0), top_title, font=font_main_h)
    cdraw.text(((COMB_W - (tb_m[2] - tb_m[0])) // 2, 45), top_title, fill=COLOR_PRIMARY, font=font_main_h)
    
    font_main_sub = get_font(24, bold=False)
    sub_title_text = "Scan with any smartphone camera for direct catalogue downloads and instant RFQ quotations"
    tb_ms = cdraw.textbbox((0, 0), sub_title_text, font=font_main_sub)
    cdraw.text(((COMB_W - (tb_ms[2] - tb_ms[0])) // 2, 105), sub_title_text, fill=COLOR_MUTED, font=font_main_sub)
    
    # Paste the two cards
    scaled_card_w = 980
    scaled_card_h = int(1360 * (scaled_card_w / 1000))
    
    c1 = card_catalogue.resize((scaled_card_w, scaled_card_h), Image.Resampling.LANCZOS)
    c2 = card_contact.resize((scaled_card_w, scaled_card_h), Image.Resampling.LANCZOS)
    
    combined.paste(c1, (70, 160), c1)
    combined.paste(c2, (1110, 160), c2)
    
    combined_path = os.path.join(OUTPUT_DIR, "qr_codes_combined.png")
    combined.save(combined_path, "PNG", dpi=(300, 300))
    print(f"Saved: {combined_path}")
    
    print("\nALL QR CODES WITH CORRECTED 'CATALOGUE' SPELLING GENERATED SUCCESSFULLY!")

if __name__ == "__main__":
    main()
