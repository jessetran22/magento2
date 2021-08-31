<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-28757: Create Downloadable Product with invalid domain link url")
 * @Description("Admin should not be able to create downloadable product with invalid domain link url<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/AdminCreateDownloadableProductWithInvalidDomainLinkUrlTest.xml<br>")
 * @TestCaseId("MC-28757")
 * @group Downloadable
 */
class AdminCreateDownloadableProductWithInvalidDomainLinkUrlTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete created downloadable product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "downloadableproduct" . msq("DownloadableProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "DownloadableProduct" . msq("DownloadableProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("downloadableproduct" . msq("DownloadableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Log out");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Stories({"Create Downloadable Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Downloadable"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateDownloadableProductWithInvalidDomainLinkUrlTest(AcceptanceTester $I)
	{
		$I->comment("Create downloadable product");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [createProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexCreateProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-downloadable']"); // stepKey: clickAddProductCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadCreateProduct
		$I->comment("Exiting Action Group [createProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("Fill downloadable product values");
		$I->comment("Entering Action Group [fillDownloadableProductForm] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "DownloadableProduct" . msq("DownloadableProduct")); // stepKey: fillProductNameFillDownloadableProductForm
		$I->fillField(".admin__field[data-index=sku] input", "downloadableproduct" . msq("DownloadableProduct")); // stepKey: fillProductSkuFillDownloadableProductForm
		$I->fillField(".admin__field[data-index=price] input", "50.99"); // stepKey: fillProductPriceFillDownloadableProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillDownloadableProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillDownloadableProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillDownloadableProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillDownloadableProductForm
		$I->comment("Exiting Action Group [fillDownloadableProductForm] FillMainProductFormNoWeightActionGroup");
		$I->comment("Add downloadable product to category");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategory
		$I->waitForPageLoad(30); // stepKey: fillCategoryWaitForPageLoad
		$I->comment("Fill downloadable link information before the creation link");
		$I->comment("Entering Action Group [addDownloadableLinkInformation] AdminAddDownloadableLinkInformationActionGroup");
		$I->click("div[data-index='downloadable']"); // stepKey: openDownloadableSectionAddDownloadableLinkInformation
		$I->waitForPageLoad(30); // stepKey: openDownloadableSectionAddDownloadableLinkInformationWaitForPageLoad
		$I->checkOption("input[name='is_downloadable']"); // stepKey: checkOptionIsDownloadableAddDownloadableLinkInformation
		$I->fillField("input[name='product[links_title]']", "Downloadable Links"); // stepKey: fillLinkTitleAddDownloadableLinkInformation
		$I->fillField("input[name='product[samples_title]']", "Downloadable Samples"); // stepKey: fillSampleTitleAddDownloadableLinkInformation
		$I->comment("Exiting Action Group [addDownloadableLinkInformation] AdminAddDownloadableLinkInformationActionGroup");
		$I->comment("Links can be purchased separately");
		$I->checkOption("input[name='product[links_purchased_separately]']"); // stepKey: checkOptionPurchaseSeparately
		$I->comment("Add downloadable link");
		$I->comment("Entering Action Group [addDownloadableProductLink] AddDownloadableProductLinkActionGroup");
		$I->click("div[data-index='container_links'] button[data-action='add_new_row']"); // stepKey: clickLinkAddLinkButtonAddDownloadableProductLink
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddDownloadableProductLink
		$I->fillField("input[name='downloadable[link][0][title]']", "DownloadableLink" . msq("downloadableLink")); // stepKey: fillDownloadableLinkTitleAddDownloadableProductLink
		$I->fillField("input[name='downloadable[link][0][price]']", "2.00"); // stepKey: fillDownloadableLinkPriceAddDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][0][type]']", "URL"); // stepKey: selectDownloadableLinkFileTypeAddDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][0][sample][type]']", "Upload File"); // stepKey: selectDownloadableLinkSampleTypeAddDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][0][is_shareable]']", "No"); // stepKey: selectDownloadableLinkShareableAddDownloadableProductLink
		$I->checkOption("input[name='downloadable[link][0][is_unlimited]']"); // stepKey: checkDownloadableLinkUnlimitedAddDownloadableProductLink
		$I->fillField("input[name='downloadable[link][0][link_url]']", "https://static.magento.com/sites/all/themes/mag_redesign/images/magento-logo.svg"); // stepKey: fillDownloadableLinkFileUrlAddDownloadableProductLink
		$I->attachFile("div[data-index='container_links'] tr[data-repeat-index='0'] fieldset[data-index='container_sample'] input[type='file']", "magento-logo.png"); // stepKey: attachDownloadableLinkUploadSampleAddDownloadableProductLink
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterFillingOutFormAddDownloadableProductLink
		$I->comment("Exiting Action Group [addDownloadableProductLink] AddDownloadableProductLinkActionGroup");
		$I->comment("Save product");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormNoSuccessCheckActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormNoSuccessCheckActionGroup");
		$I->see("Link URL's domain is not in list of downloadable_domains in env.php.", ".message.message-error.error"); // stepKey: seeLinkUrlInvalidMessage
		$addDownloadableDomain2 = $I->magentoCLI("downloadable:domains:add static.magento.com", 60); // stepKey: addDownloadableDomain2
		$I->comment($addDownloadableDomain2);
		$I->comment("Entering Action Group [fillDownloadableProductFormAgain] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "DownloadableProduct" . msq("DownloadableProduct")); // stepKey: fillProductNameFillDownloadableProductFormAgain
		$I->fillField(".admin__field[data-index=sku] input", "downloadableproduct" . msq("DownloadableProduct")); // stepKey: fillProductSkuFillDownloadableProductFormAgain
		$I->fillField(".admin__field[data-index=price] input", "50.99"); // stepKey: fillProductPriceFillDownloadableProductFormAgain
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillDownloadableProductFormAgain
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillDownloadableProductFormAgain
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillDownloadableProductFormAgainWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillDownloadableProductFormAgain
		$I->comment("Exiting Action Group [fillDownloadableProductFormAgain] FillMainProductFormNoWeightActionGroup");
		$I->checkOption("input[name='is_downloadable']"); // stepKey: checkIsDownloadable
		$I->checkOption("input[name='product[links_purchased_separately]']"); // stepKey: checkIsLinksPurchasedSeparately
		$I->comment("Entering Action Group [addDownloadableProductLinkAgain] AddDownloadableProductLinkActionGroup");
		$I->click("div[data-index='container_links'] button[data-action='add_new_row']"); // stepKey: clickLinkAddLinkButtonAddDownloadableProductLinkAgain
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddDownloadableProductLinkAgain
		$I->fillField("input[name='downloadable[link][0][title]']", "DownloadableLink" . msq("downloadableLink")); // stepKey: fillDownloadableLinkTitleAddDownloadableProductLinkAgain
		$I->fillField("input[name='downloadable[link][0][price]']", "2.00"); // stepKey: fillDownloadableLinkPriceAddDownloadableProductLinkAgain
		$I->selectOption("select[name='downloadable[link][0][type]']", "URL"); // stepKey: selectDownloadableLinkFileTypeAddDownloadableProductLinkAgain
		$I->selectOption("select[name='downloadable[link][0][sample][type]']", "Upload File"); // stepKey: selectDownloadableLinkSampleTypeAddDownloadableProductLinkAgain
		$I->selectOption("select[name='downloadable[link][0][is_shareable]']", "No"); // stepKey: selectDownloadableLinkShareableAddDownloadableProductLinkAgain
		$I->checkOption("input[name='downloadable[link][0][is_unlimited]']"); // stepKey: checkDownloadableLinkUnlimitedAddDownloadableProductLinkAgain
		$I->fillField("input[name='downloadable[link][0][link_url]']", "https://static.magento.com/sites/all/themes/mag_redesign/images/magento-logo.svg"); // stepKey: fillDownloadableLinkFileUrlAddDownloadableProductLinkAgain
		$I->attachFile("div[data-index='container_links'] tr[data-repeat-index='0'] fieldset[data-index='container_sample'] input[type='file']", "magento-logo.png"); // stepKey: attachDownloadableLinkUploadSampleAddDownloadableProductLinkAgain
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterFillingOutFormAddDownloadableProductLinkAgain
		$I->comment("Exiting Action Group [addDownloadableProductLinkAgain] AddDownloadableProductLinkActionGroup");
		$I->comment("Entering Action Group [saveProductAfterAddingDomainToAllowlist] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductAfterAddingDomainToAllowlist
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductAfterAddingDomainToAllowlist
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductAfterAddingDomainToAllowlistWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductAfterAddingDomainToAllowlist
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductAfterAddingDomainToAllowlistWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductAfterAddingDomainToAllowlist
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductAfterAddingDomainToAllowlist
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductAfterAddingDomainToAllowlist
		$I->comment("Exiting Action Group [saveProductAfterAddingDomainToAllowlist] SaveProductFormActionGroup");
		$runIndexCronJobs = $I->magentoCron("index", 90); // stepKey: runIndexCronJobs
		$I->comment($runIndexCronJobs);
		$I->comment("Assert product in storefront category page");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->comment("Entering Action Group [StorefrontCheckCategorySimpleProduct] StorefrontCheckProductPriceInCategoryActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), 'DownloadableProduct" . msq("DownloadableProduct") . "')]", 30); // stepKey: waitForProductStorefrontCheckCategorySimpleProduct
		$I->seeElement("//main//li//a[contains(text(), 'DownloadableProduct" . msq("DownloadableProduct") . "')]"); // stepKey: assertProductNameStorefrontCheckCategorySimpleProduct
		$I->see("50.99", "//main//li[.//a[contains(text(), 'DownloadableProduct" . msq("DownloadableProduct") . "')]]//span[@class='price']"); // stepKey: AssertProductPriceStorefrontCheckCategorySimpleProduct
		$I->moveMouseOver("//main//li[.//a[contains(text(), 'DownloadableProduct" . msq("DownloadableProduct") . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductStorefrontCheckCategorySimpleProduct
		$I->seeElement("//main//li[.//a[contains(text(), 'DownloadableProduct" . msq("DownloadableProduct") . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartStorefrontCheckCategorySimpleProduct
		$I->comment("Exiting Action Group [StorefrontCheckCategorySimpleProduct] StorefrontCheckProductPriceInCategoryActionGroup");
		$I->comment("Assert product in storefront product page");
		$I->comment("Entering Action Group [AssertProductInStorefrontProductPage] AssertProductNameAndSkuInStorefrontProductPageActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage("downloadableproduct" . msq("DownloadableProduct") . ".html"); // stepKey: navigateToProductPageAssertProductInStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssertProductInStorefrontProductPage
		$I->seeInTitle("DownloadableProduct" . msq("DownloadableProduct")); // stepKey: assertProductNameTitleAssertProductInStorefrontProductPage
		$I->see("DownloadableProduct" . msq("DownloadableProduct"), ".base"); // stepKey: assertProductNameAssertProductInStorefrontProductPage
		$I->see("downloadableproduct" . msq("DownloadableProduct"), ".product.attribute.sku>.value"); // stepKey: assertProductSkuAssertProductInStorefrontProductPage
		$I->comment("Exiting Action Group [AssertProductInStorefrontProductPage] AssertProductNameAndSkuInStorefrontProductPageActionGroup");
		$I->comment("Assert product price in storefront product page");
		$I->see("50.99", "div.price-box.price-final_price"); // stepKey: assertProductPrice
		$I->comment("Select product link in storefront product page");
		$I->scrollTo("//*[@id='downloadable-links-list']/*[contains(.,'DownloadableLink" . msq("downloadableLink") . "')]//input"); // stepKey: scrollToLinks
		$I->waitForPageLoad(30); // stepKey: scrollToLinksWaitForPageLoad
		$I->click("//*[@id='downloadable-links-list']/*[contains(.,'DownloadableLink" . msq("downloadableLink") . "')]//input"); // stepKey: selectProductLink
		$I->waitForPageLoad(30); // stepKey: selectProductLinkWaitForPageLoad
		$I->comment("Add product with selected link to the cart");
		$I->scrollTo("button#product-addtocart-button"); // stepKey: scrollToAddToCart
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added DownloadableProduct" . msq("DownloadableProduct") . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Assert product price in cart");
		$I->comment("Entering Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenShoppingCartPage
		$I->comment("Exiting Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->see("$52.99", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='DownloadableProduct" . msq("DownloadableProduct") . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPriceInCart
	}
}
