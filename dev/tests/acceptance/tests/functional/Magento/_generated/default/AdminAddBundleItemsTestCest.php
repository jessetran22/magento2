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
 * @Title("MC-223: Admin should be able to add/edit bundle items when creating/editing a bundle product")
 * @Description("Admin should be able to add/edit bundle items when creating/editing a bundle product<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/AdminAddBundleItemsTest.xml<br>")
 * @TestCaseId("MC-223")
 * @group Bundle
 */
class AdminAddBundleItemsTestCest
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
		$I->comment("Creating data");
		$I->createEntity("createPreReqCategory", "hook", "_defaultCategory", [], []); // stepKey: createPreReqCategory
		$I->createEntity("simpleProduct0", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct0
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct2
		$I->createEntity("simpleProduct3", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct3
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
		$I->comment("Admin login");
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Deleting data");
		$I->deleteEntity("createPreReqCategory", "hook"); // stepKey: deletePreReqCategory
		$I->deleteEntity("simpleProduct0", "hook"); // stepKey: deleteSimpleProduct0
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("simpleProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->comment("Logging out");
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
	 * @Features({"Bundle"})
	 * @Stories({"Create/Edit bundle product in Admin"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddBundleItemsTest(AcceptanceTester $I)
	{
		$I->comment("Go to bundle product creation page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/bundle/"); // stepKey: goToBundleProductCreationPage
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductCreatePageToLoad
		$I->comment("Add two bundle items");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItems
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOption3
		$I->waitForElementVisible("[name='bundle_options[bundle_options][0][title]']", 30); // stepKey: waitForBundleOptions
		$I->fillField("[name='bundle_options[bundle_options][0][title]']", "BundleOption"); // stepKey: fillOptionTitle
		$I->selectOption("[name='bundle_options[bundle_options][0][type]']", "checkbox"); // stepKey: selectInputType
		$I->comment("Entering Action Group [clickAddProductsToOption] AdminClickAddProductToOptionActionGroup");
		$I->waitForElementVisible("[data-index='modal_set']", 30); // stepKey: waitForAddProductsToBundleClickAddProductsToOption
		$I->waitForPageLoad(30); // stepKey: waitForAddProductsToBundleClickAddProductsToOptionWaitForPageLoad
		$I->click("[data-index='modal_set']"); // stepKey: clickAddProductsToOptionClickAddProductsToOption
		$I->waitForPageLoad(30); // stepKey: clickAddProductsToOptionClickAddProductsToOptionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterBundleProductsClickAddProductsToOption
		$I->comment("Exiting Action Group [clickAddProductsToOption] AdminClickAddProductToOptionActionGroup");
		$I->comment("Entering Action Group [filterBundleProductOptions] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterBundleProductOptions
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterBundleProductOptionsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterBundleProductOptions
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct0', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterBundleProductOptions
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterBundleProductOptions
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterBundleProductOptionsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterBundleProductOptions
		$I->comment("Exiting Action Group [filterBundleProductOptions] FilterProductGridBySkuActionGroup");
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectFirstGridRow
		$I->comment("Entering Action Group [filterBundleProductOptions2] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterBundleProductOptions2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterBundleProductOptions2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterBundleProductOptions2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterBundleProductOptions2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterBundleProductOptions2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterBundleProductOptions2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterBundleProductOptions2
		$I->comment("Exiting Action Group [filterBundleProductOptions2] FilterProductGridBySkuActionGroup");
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectFirstGridRow2
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddSelectedBundleProducts
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedBundleProductsWaitForPageLoad
		$I->comment("Check that Bundle Options initialized with default quantity");
		$grabbedFirstBundleOptionQuantity = $I->grabValueFrom("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']"); // stepKey: grabbedFirstBundleOptionQuantity
		$I->assertEquals("1", "$grabbedFirstBundleOptionQuantity"); // stepKey: assertFirstBundleOptionDefaultQuantity
		$grabbedSecondBundleOptionQuantity = $I->grabValueFrom("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_qty]']"); // stepKey: grabbedSecondBundleOptionQuantity
		$I->assertEquals("1", "$grabbedSecondBundleOptionQuantity"); // stepKey: assertSecondBundleOptionDefaultQuantity
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "10"); // stepKey: fillProductDefaultQty1
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_qty]']", "10"); // stepKey: fillProductDefaultQty2
		$I->comment("Fill out ancillary data on bundle product");
		$I->comment("Entering Action Group [createBundledProductForTwoSimpleProducts] AncillaryPrepBundleProductActionGroup");
		$I->comment("PreReq: go to bundle product creation page");
		$I->fillField("//*[@name='product[name]']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameCreateBundledProductForTwoSimpleProducts
		$I->fillField("//*[@name='product[sku]']", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuCreateBundledProductForTwoSimpleProducts
		$I->comment("Trigger SEO drop down");
		$I->scrollTo("//div[@data-index='search-engine-optimization']"); // stepKey: moveToSEOSectionCreateBundledProductForTwoSimpleProducts
		$I->conditionalClick("//div[@data-index='search-engine-optimization']", "//input[@name='product[url_key]']", false); // stepKey: openDropDownIfClosedCreateBundledProductForTwoSimpleProducts
		$I->waitForPageLoad(30); // stepKey: openDropDownIfClosedCreateBundledProductForTwoSimpleProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForDropDownSEOCreateBundledProductForTwoSimpleProducts
		$I->comment("Fill URL input");
		$I->fillField("//input[@name='product[url_key]']", "bundleproduct" . msq("BundleProduct")); // stepKey: FillsinSEOlinkExtensionCreateBundledProductForTwoSimpleProducts
		$I->waitForPageLoad(30); // stepKey: FillsinSEOlinkExtensionCreateBundledProductForTwoSimpleProductsWaitForPageLoad
		$I->comment("Exiting Action Group [createBundledProductForTwoSimpleProducts] AncillaryPrepBundleProductActionGroup");
		$I->comment("Save the product");
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->see("You saved the product."); // stepKey: messageYouSavedTheProductIsShown
		$I->comment("Checking on admin side");
		$I->scrollToTopOfPage(); // stepKey: scroll
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItems2
		$I->seeElement("//tr[@data-repeat-index='0']//div"); // stepKey: LookingForBundleItemPresence
		$I->comment("Checking on customer side");
		$I->amOnPage("bundleproduct" . msq("BundleProduct") . ".html"); // stepKey: GoToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductPageToLoad
		$I->seeElement("#bundle-slide"); // stepKey: LookingForAbilityToAddOptions
		$I->click("#bundle-slide"); // stepKey: clickButtonToCustomize
		$I->waitForPageLoad(30); // stepKey: waitCustomizationDropDown
		$I->seeElement("//div[@class='field choice'][1]//input[@type='checkbox']"); // stepKey: seeBundleItem
		$I->comment("Add another bundle option with 2 items");
		$I->comment("Go to bundle product creation page");
		$I->comment("Entering Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToCatalogProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCatalogProductPage
		$I->comment("Exiting Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresent
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForClear
		$I->comment("Entering Action Group [filterBundleProductOptionsDownToName] FilterProductGridByNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterBundleProductOptionsDownToName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterBundleProductOptionsDownToNameWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterBundleProductOptionsDownToName
		$I->fillField("input.admin__control-text[name='name']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFilterFilterBundleProductOptionsDownToName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterBundleProductOptionsDownToName
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterBundleProductOptionsDownToNameWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterBundleProductOptionsDownToName
		$I->comment("Exiting Action Group [filterBundleProductOptionsDownToName] FilterProductGridByNameActionGroup");
		$I->click("//tr[@data-repeat-index='0']//td[4]"); // stepKey: clickOnBundleProductToEdit
		$I->waitForPageLoad(30); // stepKey: clickOnBundleProductToEditWaitForPageLoad
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsToEdit
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOption
		$I->waitForElementVisible("[name='bundle_options[bundle_options][1][title]']", 30); // stepKey: waitForBundleOptionsToAppear
		$I->fillField("[name='bundle_options[bundle_options][1][title]']", "BundleOption"); // stepKey: fillNewestOptionTitle
		$I->selectOption("[name='bundle_options[bundle_options][1][type]']", "checkbox"); // stepKey: selectNewInputType
		$I->comment("Entering Action Group [clickAddProductsToNewOption] AdminClickAddProductToOptionActionGroup");
		$I->waitForElementVisible("[data-index='modal_set']", 30); // stepKey: waitForAddProductsToBundleClickAddProductsToNewOption
		$I->waitForPageLoad(30); // stepKey: waitForAddProductsToBundleClickAddProductsToNewOptionWaitForPageLoad
		$I->click("[data-index='modal_set']"); // stepKey: clickAddProductsToOptionClickAddProductsToNewOption
		$I->waitForPageLoad(30); // stepKey: clickAddProductsToOptionClickAddProductsToNewOptionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterBundleProductsClickAddProductsToNewOption
		$I->comment("Exiting Action Group [clickAddProductsToNewOption] AdminClickAddProductToOptionActionGroup");
		$I->comment("Entering Action Group [filterNewBundleProductOptions] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterNewBundleProductOptions
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterNewBundleProductOptionsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterNewBundleProductOptions
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterNewBundleProductOptions
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterNewBundleProductOptions
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterNewBundleProductOptionsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterNewBundleProductOptions
		$I->comment("Exiting Action Group [filterNewBundleProductOptions] FilterProductGridBySkuActionGroup");
		$I->checkOption("//div[@class='admin__data-grid-outer-wrap']//tr[@data-repeat-index='0']//input[@type='checkbox']"); // stepKey: selectNewFirstGridRow
		$I->comment("Entering Action Group [filterNewBundleProductOptions2] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterNewBundleProductOptions2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterNewBundleProductOptions2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterNewBundleProductOptions2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct3', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterNewBundleProductOptions2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterNewBundleProductOptions2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterNewBundleProductOptions2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterNewBundleProductOptions2
		$I->comment("Exiting Action Group [filterNewBundleProductOptions2] FilterProductGridBySkuActionGroup");
		$I->checkOption("//div[@class='admin__data-grid-outer-wrap']//tr[@data-repeat-index='0']//input[@type='checkbox']"); // stepKey: selectNewFirstGridRow2
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddNewSelectedBundleProducts
		$I->waitForPageLoad(30); // stepKey: clickAddNewSelectedBundleProductsWaitForPageLoad
		$I->comment("Check that existing Bundle Options do not loose user input quantity values");
		$grabbedFirstBundleOptionQuantityAfterUserInput = $I->grabValueFrom("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']"); // stepKey: grabbedFirstBundleOptionQuantityAfterUserInput
		$I->assertEquals("10", "$grabbedFirstBundleOptionQuantityAfterUserInput"); // stepKey: assertFirstBundleOptionDefaultQuantityAfterUserInput
		$grabbedSecondBundleOptionQuantityAfterUserInput = $I->grabValueFrom("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_qty]']"); // stepKey: grabbedSecondBundleOptionQuantityAfterUserInput
		$I->assertEquals("10", "$grabbedSecondBundleOptionQuantityAfterUserInput"); // stepKey: assertSecondBundleOptionDefaultQuantityAfterUserInput
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][2][selection_qty]']", "10"); // stepKey: fillNewProductDefaultQty1
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][3][selection_qty]']", "10"); // stepKey: fillNewProductDefaultQty2
		$I->comment("Save the product");
		$I->comment("Entering Action Group [clickSaveButtonAgain] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButtonAgain
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonAgainWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButtonAgain
		$I->comment("Exiting Action Group [clickSaveButtonAgain] AdminProductFormSaveActionGroup");
		$I->see("You saved the product."); // stepKey: messageYouSavedTheProductIsShownAgain
		$I->comment("Checking on admin side");
		$I->scrollToTopOfPage(); // stepKey: scrollAgain
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenNewSectionBundleItems2
		$I->seeElement("//tr[@data-repeat-index='2']//div"); // stepKey: LookingForNewBundleItemPresence
		$I->comment("Checking on customer side");
		$I->amOnPage("bundleproduct" . msq("BundleProduct") . ".html"); // stepKey: GoToProductPageAgain
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductPageToLoadAgain
		$I->seeElement("#bundle-slide"); // stepKey: LookingForAbilityToAddBothOptions
		$I->click("#bundle-slide"); // stepKey: clickButtonAgainToCustomize
		$I->waitForPageLoad(30); // stepKey: waitForBothCustomizationDropDown
		$I->seeElement("//div[@class='field choice'][2]//input[@type='checkbox']"); // stepKey: seeBundleItems
	}
}
