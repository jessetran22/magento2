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
 * @Title("[NO TESTCASEID]: Customer should get the right subtotal in cart when the bundle product with tier price for sub-item added to the cart")
 * @Description("Customer should be able to add bundle product with tier price for sub-item price to the cart and get the right price<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/BundleProductWithOptionTierPriceInCartTest.xml<br>")
 */
class BundleProductWithOptionTierPriceInCartTestCest
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
		$createProductForBundleItem1Fields['price'] = "50.00";
		$I->createEntity("createProductForBundleItem1", "hook", "VirtualProduct", [], $createProductForBundleItem1Fields); // stepKey: createProductForBundleItem1
		$createProductForBundleItem2Fields['price'] = "100.00";
		$I->createEntity("createProductForBundleItem2", "hook", "SimpleProduct2", [], $createProductForBundleItem2Fields); // stepKey: createProductForBundleItem2
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->createEntity("addTierPrice", "hook", "TierProductPrice50PercentDiscount", ["createProductForBundleItem2"], []); // stepKey: addTierPrice
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProductForBundleItem1", "hook"); // stepKey: deleteProductForBundleItem1
		$I->deleteEntity("createProductForBundleItem2", "hook"); // stepKey: deleteProductForBundleItem2
		$I->comment("Entering Action Group [deleteBundle] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteBundle
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteBundle
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteBundleWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteBundle
		$I->fillField("input.admin__control-text[name='sku']", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuFilterDeleteBundle
		$I->fillField("input.admin__control-text[name='name']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFilterDeleteBundle
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteBundleWaitForPageLoad
		$I->see("bundleproduct" . msq("BundleProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteBundle
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteBundle
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteBundle
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteBundleWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteBundleWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteBundle
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteBundle
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteBundleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteBundle] DeleteProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [clearProductsGridFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearProductsGridFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductsGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsGridFilters] AdminClearFiltersActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForClearProductsGridFilters
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Add bundle product to cart on storefront"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Bundle"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function BundleProductWithOptionTierPriceInCartTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/bundle/"); // stepKey: goToBundleProductCreationPage
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductCreatePageToLoad
		$I->comment("Entering Action Group [fillMainFieldsForBundle] FillMainBundleProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductSkuFillMainFieldsForBundle
		$I->fillField(".admin__field[data-index=sku] input", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductNameFillMainFieldsForBundle
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillMainFieldsForBundle
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillMainFieldsForBundleWaitForPageLoad
		$I->comment("Exiting Action Group [fillMainFieldsForBundle] FillMainBundleProductFormActionGroup");
		$I->comment("Entering Action Group [addBundleOption1] AddBundleOptionWithOneProductActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOption1
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOption1
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOption1
		$I->waitForElementVisible("[name='bundle_options[bundle_options][0][title]']", 30); // stepKey: waitForOptionsAddBundleOption1
		$I->fillField("[name='bundle_options[bundle_options][0][title]']", "Option1"); // stepKey: fillTitleAddBundleOption1
		$I->selectOption("[name='bundle_options[bundle_options][0][type]']", "checkbox"); // stepKey: selectTypeAddBundleOption1
		$I->waitForElementVisible("//tr[1]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOption1
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOption1WaitForPageLoad
		$I->click("//tr[1]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOption1
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOption1WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOption1
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOption1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOption1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProductForBundleItem1', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOption1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOption1
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOption1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOption1
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOption1
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOption1
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOption1WaitForPageLoad
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOption1
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOption1WaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "1"); // stepKey: fillQuantityAddBundleOption1
		$I->comment("Exiting Action Group [addBundleOption1] AddBundleOptionWithOneProductActionGroup");
		$I->comment("Entering Action Group [addBundleOption2] AddBundleOptionWithOneProductActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOption2
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOption2
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOption2
		$I->waitForElementVisible("[name='bundle_options[bundle_options][1][title]']", 30); // stepKey: waitForOptionsAddBundleOption2
		$I->fillField("[name='bundle_options[bundle_options][1][title]']", "Option2"); // stepKey: fillTitleAddBundleOption2
		$I->selectOption("[name='bundle_options[bundle_options][1][type]']", "checkbox"); // stepKey: selectTypeAddBundleOption2
		$I->waitForElementVisible("//tr[2]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOption2
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOption2WaitForPageLoad
		$I->click("//tr[2]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOption2
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOption2WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOption2
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOption2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOption2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProductForBundleItem2', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOption2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOption2
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOption2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOption2
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOption2
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOption2
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOption2WaitForPageLoad
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOption2
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOption2WaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][1][bundle_selections][0][selection_qty]']", "1"); // stepKey: fillQuantityAddBundleOption2
		$I->comment("Exiting Action Group [addBundleOption2] AddBundleOptionWithOneProductActionGroup");
		$I->comment("Entering Action Group [saveBundleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveBundleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveBundleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveBundleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveBundleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveBundleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveBundleProduct
		$I->comment("Exiting Action Group [saveBundleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfTheProductPage
		$I->amOnPage("/bundleproduct" . msq("BundleProduct") . ".html"); // stepKey: goToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefront
		$I->comment("Assert Bundle Product Price");
		$grabProductPrice = $I->grabTextFrom("div.price-box.price-final_price > span.price-final_price span.price"); // stepKey: grabProductPrice
		$I->assertEquals("$100.00", $grabProductPrice, "ExpectedPrice"); // stepKey: assertBundleProductPrice
		$I->comment("Entering Action Group [clickOnCustomizeAndAddToCartButton] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickOnCustomizeAndAddToCartButton
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickOnCustomizeAndAddToCartButtonWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickOnCustomizeAndAddToCartButton
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickOnCustomizeAndAddToCartButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickOnCustomizeAndAddToCartButton
		$I->comment("Exiting Action Group [clickOnCustomizeAndAddToCartButton] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->comment("Entering Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->clearField("#qty"); // stepKey: clearTheQuantityFieldEnterProductQuantityAndAddToTheCart
		$I->fillField("#qty", "1"); // stepKey: fillTheProductQuantityEnterProductQuantityAndAddToTheCart
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadEnterProductQuantityAndAddToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageEnterProductQuantityAndAddToTheCart
		$I->comment("Exiting Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->comment("Entering Action Group [assertSubTotalOnStorefrontMiniCart] AssertSubTotalOnStorefrontMiniCartActionGroup");
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForShowCartButtonVisibleAssertSubTotalOnStorefrontMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForShowCartButtonVisibleAssertSubTotalOnStorefrontMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartAssertSubTotalOnStorefrontMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartAssertSubTotalOnStorefrontMiniCartWaitForPageLoad
		$grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart = $I->grabTextFrom(".block-minicart .amount span.price"); // stepKey: grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart
		$I->assertEquals("$100.00", $grabTextFromMiniCartSubtotalFieldAssertSubTotalOnStorefrontMiniCart, "Mini shopping cart should contain subtotal $100.00"); // stepKey: assertSubtotalFieldFromMiniShoppingCart1AssertSubTotalOnStorefrontMiniCart
		$I->comment("Exiting Action Group [assertSubTotalOnStorefrontMiniCart] AssertSubTotalOnStorefrontMiniCartActionGroup");
	}
}
