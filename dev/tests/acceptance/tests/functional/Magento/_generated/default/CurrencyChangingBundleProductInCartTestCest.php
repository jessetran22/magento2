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
 * @Title("MAGETWO-94467: User should be able change the currency and get right price in cart when the bundle product added to the cart")
 * @Description("User should be able change the currency and add one more product in cart and get right price in previous currency<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/CurrencyChangingBundleProductInCartTest.xml<br>")
 * @TestCaseId("MAGETWO-94467")
 * @group Bundle
 */
class CurrencyChangingBundleProductInCartTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct2
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete the bundled product");
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
		$I->comment("Entering Action Group [ClearFiltersAfter] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFiltersAfter
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFiltersAfter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersAfter
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersAfterWaitForPageLoad
		$I->comment("Exiting Action Group [ClearFiltersAfter] AdminClearFiltersActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForClearFilter
		$I->comment("Clear Configs");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdmin
		$I->waitForPageLoad(30); // stepKey: waitForAdminLoginPageLoad
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/currency"); // stepKey: navigateToConfigCurrencySetupPage
		$I->waitForPageLoad(30); // stepKey: waitForConfigCurrencySetupPageForUnselectEuroCurrency
		$I->unselectOption("#currency_options_allow", "Euro"); // stepKey: unselectEuro
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage
		$I->click("#currency_options-head"); // stepKey: closeOptions
		$I->waitForPageLoad(30); // stepKey: waitForCloseOptions
		$I->click("#save"); // stepKey: saveUnselectedConfigs
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
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
	 * @Features({"Bundle"})
	 * @Stories({"Check that after changing currency price of cart is correct when the bundle product added to the cart"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CurrencyChangingBundleProductInCartTest(AcceptanceTester $I)
	{
		$I->comment("Go to bundle product creation page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/bundle/"); // stepKey: goToBundleProductCreationPage
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductCreatePageToLoad
		$I->comment("Entering Action Group [fillMainFieldsForBundle] FillMainBundleProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductSkuFillMainFieldsForBundle
		$I->fillField(".admin__field[data-index=sku] input", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductNameFillMainFieldsForBundle
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillMainFieldsForBundle
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillMainFieldsForBundleWaitForPageLoad
		$I->comment("Exiting Action Group [fillMainFieldsForBundle] FillMainBundleProductFormActionGroup");
		$I->comment("Add Option, a \"Radio Buttons\" type option");
		$I->comment("Entering Action Group [addBundleOptionWithTwoProducts2] AddBundleOptionWithTwoProductsActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddBundleOptionWithTwoProducts2
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddBundleOptionWithTwoProducts2
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddBundleOptionWithTwoProducts2
		$I->waitForElementVisible("[name='bundle_options[bundle_options][0][title]']", 30); // stepKey: waitForOptionsAddBundleOptionWithTwoProducts2
		$I->fillField("[name='bundle_options[bundle_options][0][title]']", "Option"); // stepKey: fillTitleAddBundleOptionWithTwoProducts2
		$I->selectOption("[name='bundle_options[bundle_options][0][type]']", "radio"); // stepKey: selectTypeAddBundleOptionWithTwoProducts2
		$I->waitForElementVisible("//tr[1]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->click("//tr[1]//button[@data-index='modal_set']"); // stepKey: clickAddAddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickAddAddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddBundleOptionWithTwoProducts2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddBundleOptionWithTwoProducts2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddBundleOptionWithTwoProducts2
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddBundleOptionWithTwoProducts2
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters2AddBundleOptionWithTwoProducts2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilter2AddBundleOptionWithTwoProducts2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters2AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad2AddBundleOptionWithTwoProducts2
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct2AddBundleOptionWithTwoProducts2
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts2
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddBundleOptionWithTwoProducts2WaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "50"); // stepKey: fillQuantity1AddBundleOptionWithTwoProducts2
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_qty]']", "50"); // stepKey: fillQuantity2AddBundleOptionWithTwoProducts2
		$I->comment("Exiting Action Group [addBundleOptionWithTwoProducts2] AddBundleOptionWithTwoProductsActionGroup");
		$I->checkOption("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_can_change_qty]'][type='checkbox']"); // stepKey: userDefinedQuantitiyOptionProduct0
		$I->checkOption("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_can_change_qty]'][type='checkbox']"); // stepKey: userDefinedQuantitiyOptionProduct1
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/currency"); // stepKey: navigateToConfigCurrencySetupPage
		$I->waitForPageLoad(30); // stepKey: waitForConfigCurrencySetupPage
		$I->conditionalClick("#currency_options-head", "#currency_options_allow", false); // stepKey: openOptions
		$I->waitForPageLoad(30); // stepKey: waitForOptions
		$I->selectOption("#currency_options_allow", ['Euro',  'US Dollar']); // stepKey: selectCurrencies
		$I->click("#save"); // stepKey: saveConfigs
		$I->comment("Go to storefront BundleProduct");
		$I->amOnPage("bundleproduct" . msq("BundleProduct") . ".html"); // stepKey: goToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefront
		$I->comment("Entering Action Group [addProduct1ToCartAndChangeCurrencyToEuro] StoreFrontAddProductToCartFromBundleWithCurrencyActionGroup");
		$I->click("#switcher-currency-trigger"); // stepKey: openCurrencyTriggerAddProduct1ToCartAndChangeCurrencyToEuro
		$I->waitForPageLoad(30); // stepKey: openCurrencyTriggerAddProduct1ToCartAndChangeCurrencyToEuroWaitForPageLoad
		$I->click("//a[text()='EUR - Euro']"); // stepKey: chooseCurrencyAddProduct1ToCartAndChangeCurrencyToEuro
		$I->click("#bundle-slide"); // stepKey: clickCustomizeAddProduct1ToCartAndChangeCurrencyToEuro
		$I->waitForPageLoad(30); // stepKey: clickCustomizeAddProduct1ToCartAndChangeCurrencyToEuroWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForBundleOpenAddProduct1ToCartAndChangeCurrencyToEuro
		$I->checkOption("//label//span[contains(text(), '" . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . "')]"); // stepKey: chooseProductAddProduct1ToCartAndChangeCurrencyToEuro
		$I->click("#product-addtocart-button"); // stepKey: addToCartProductAddProduct1ToCartAndChangeCurrencyToEuro
		$I->waitForPageLoad(30); // stepKey: addToCartProductAddProduct1ToCartAndChangeCurrencyToEuroWaitForPageLoad
		$I->scrollToTopOfPage(); // stepKey: scrollToTopAddProduct1ToCartAndChangeCurrencyToEuro
		$I->comment("Exiting Action Group [addProduct1ToCartAndChangeCurrencyToEuro] StoreFrontAddProductToCartFromBundleWithCurrencyActionGroup");
		$I->comment("Entering Action Group [addProduct2ToCartAndChangeCurrencyToUSD] StoreFrontAddProductToCartFromBundleWithCurrencyActionGroup");
		$I->click("#switcher-currency-trigger"); // stepKey: openCurrencyTriggerAddProduct2ToCartAndChangeCurrencyToUSD
		$I->waitForPageLoad(30); // stepKey: openCurrencyTriggerAddProduct2ToCartAndChangeCurrencyToUSDWaitForPageLoad
		$I->click("//a[text()='USD - US Dollar']"); // stepKey: chooseCurrencyAddProduct2ToCartAndChangeCurrencyToUSD
		$I->click("#bundle-slide"); // stepKey: clickCustomizeAddProduct2ToCartAndChangeCurrencyToUSD
		$I->waitForPageLoad(30); // stepKey: clickCustomizeAddProduct2ToCartAndChangeCurrencyToUSDWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForBundleOpenAddProduct2ToCartAndChangeCurrencyToUSD
		$I->checkOption("//label//span[contains(text(), '" . $I->retrieveEntityField('simpleProduct2', 'name', 'test') . "')]"); // stepKey: chooseProductAddProduct2ToCartAndChangeCurrencyToUSD
		$I->click("#product-addtocart-button"); // stepKey: addToCartProductAddProduct2ToCartAndChangeCurrencyToUSD
		$I->waitForPageLoad(30); // stepKey: addToCartProductAddProduct2ToCartAndChangeCurrencyToUSDWaitForPageLoad
		$I->scrollToTopOfPage(); // stepKey: scrollToTopAddProduct2ToCartAndChangeCurrencyToUSD
		$I->comment("Exiting Action Group [addProduct2ToCartAndChangeCurrencyToUSD] StoreFrontAddProductToCartFromBundleWithCurrencyActionGroup");
		$I->comment("Entering Action Group [openMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageOpenMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniCart
		$I->comment("Exiting Action Group [openMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->see("$12,300.00"); // stepKey: seeCartSubtotal
	}
}
