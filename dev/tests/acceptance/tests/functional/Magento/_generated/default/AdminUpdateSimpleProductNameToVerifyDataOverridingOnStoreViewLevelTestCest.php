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
 * @Title("MC-10821: Update Simple Product Name to Verify Data Overriding on Store View Level")
 * @Description("Test log in to Update Simple Product and Update Simple Product Name to Verify Data Overriding on Store View Level<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateSimpleProductNameToVerifyDataOverridingOnStoreViewLevelTest.xml<br>")
 * @TestCaseId("MC-10821")
 * @group catalog
 * @group mtf_migrated
 */
class AdminUpdateSimpleProductNameToVerifyDataOverridingOnStoreViewLevelTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createCustomStoreViewFr] CreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: amOnAdminSystemStoreViewPageCreateCustomStoreViewFr
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCreateCustomStoreViewFr
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreGroupCreateCustomStoreViewFr
		$I->fillField("#store_name", "FR" . msq("customStoreFR")); // stepKey: fillStoreViewNameCreateCustomStoreViewFr
		$I->fillField("#store_code", "fr" . msq("customStoreFR")); // stepKey: fillStoreViewCodeCreateCustomStoreViewFr
		$I->selectOption("#store_is_active", "1"); // stepKey: selectStoreViewStatusCreateCustomStoreViewFr
		$I->click("#save"); // stepKey: clickSaveStoreViewButtonCreateCustomStoreViewFr
		$I->waitForPageLoad(90); // stepKey: clickSaveStoreViewButtonCreateCustomStoreViewFrWaitForPageLoad
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForAcceptNewStoreViewCreationButtonCreateCustomStoreViewFr
		$I->conditionalClick(".action-primary.action-accept", ".action-primary.action-accept", true); // stepKey: clickAcceptNewStoreViewCreationButtonCreateCustomStoreViewFr
		$I->see("You saved the store view."); // stepKey: seeSavedMessageCreateCustomStoreViewFr
		$I->comment("Exiting Action Group [createCustomStoreViewFr] CreateStoreViewActionGroup");
		$I->createEntity("initialCategoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: initialCategoryEntity
		$I->createEntity("initialSimpleProduct", "hook", "defaultSimpleProduct", ["initialCategoryEntity"], []); // stepKey: initialSimpleProduct
		$I->createEntity("categoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: categoryEntity
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("initialCategoryEntity", "hook"); // stepKey: deleteSimpleSubCategory
		$I->deleteEntity("categoryEntity", "hook"); // stepKey: deleteSimpleSubCategory2
		$I->comment("Entering Action Group [deleteCreatedProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteCreatedProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCreatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteCreatedProduct
		$I->fillField("input.admin__control-text[name='sku']", "testsku" . msq("defaultSimpleProduct")); // stepKey: fillProductSkuFilterDeleteCreatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCreatedProductWaitForPageLoad
		$I->see("testsku" . msq("defaultSimpleProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteCreatedProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteCreatedProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteCreatedProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteCreatedProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteCreatedProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteCreatedProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteCreatedProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteCreatedProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteCreatedProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCreatedProduct
		$I->comment("Exiting Action Group [deleteCreatedProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "FR" . msq("customStoreFR")); // stepKey: fillStoreViewFilterFieldDeleteStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView
		$I->comment("Exiting Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
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
	 * @Stories({"Update Simple Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateSimpleProductNameToVerifyDataOverridingOnStoreViewLevelTest(AcceptanceTester $I)
	{
		$I->comment("Search default simple product in grid");
		$I->comment("Entering Action Group [openProductCatalogPage] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadOpenProductCatalogPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentOpenProductCatalogPageWaitForPageLoad
		$I->comment("Exiting Action Group [openProductCatalogPage] AdminClearFiltersActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickFirstRowToOpenDefaultSimpleProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowClickFirstRowToOpenDefaultSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickFirstRowToOpenDefaultSimpleProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageClickFirstRowToOpenDefaultSimpleProduct
		$I->comment("Exiting Action Group [clickFirstRowToOpenDefaultSimpleProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Assign simple product to created store view");
		$I->click("#store-change-button"); // stepKey: clickCategoryStoreViewDropdownToggle
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewDropdown
		$I->waitForElementVisible("//div[contains(@class, 'store-switcher')]//a[normalize-space()='FR" . msq("customStoreFR") . "']", 30); // stepKey: waitForStoreViewOption
		$I->click("//div[contains(@class, 'store-switcher')]//a[normalize-space()='FR" . msq("customStoreFR") . "']"); // stepKey: selectCategoryStoreViewOption
		$I->waitForPageLoad(30); // stepKey: waitForAcceptModal
		$I->waitForElementVisible("button[class='action-primary action-accept']", 30); // stepKey: waitForAcceptButton
		$I->waitForPageLoad(30); // stepKey: waitForAcceptButtonWaitForPageLoad
		$I->click("button[class='action-primary action-accept']"); // stepKey: clickAcceptButton
		$I->waitForPageLoad(30); // stepKey: clickAcceptButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForThePageToLoad
		$I->waitForElementNotVisible("button[class='action-primary action-accept']", 30); // stepKey: waitForAcceptButtonGone
		$I->waitForPageLoad(30); // stepKey: waitForAcceptButtonGoneWaitForPageLoad
		$I->uncheckOption("input[name='use_default[name]']"); // stepKey: uncheckProductStatus
		$I->comment("Update default simple product with name");
		$I->fillField(".admin__field[data-index=name] input", "TestSimpleProduct" . msq("simpleProductDataOverriding")); // stepKey: fillSimpleProductName
		$I->comment("Entering Action Group [clickButtonSave] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonClickButtonSave
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonClickButtonSaveWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedClickButtonSave
		$I->comment("Exiting Action Group [clickButtonSave] AdminProductFormSaveButtonClickActionGroup");
		$I->comment("Verify customer see success message");
		$I->see("You saved the product.", "#messages"); // stepKey: seeAssertSimpleProductSaveSuccessMessage
		$I->comment("Verify customer see default simple product name on magento storefront page");
		$I->amOnPage("/" . $I->retrieveEntityField('initialSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToMagentoStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageLoad
		$I->comment("Entering Action Group [fillDefaultSimpleProductSkuInSearchTextBox] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test')); // stepKey: fillInputFillDefaultSimpleProductSkuInSearchTextBox
		$I->submitForm("#search", []); // stepKey: submitQuickSearchFillDefaultSimpleProductSkuInSearchTextBox
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlFillDefaultSimpleProductSkuInSearchTextBox
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyFillDefaultSimpleProductSkuInSearchTextBox
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test') . "'"); // stepKey: assertQuickSearchTitleFillDefaultSimpleProductSkuInSearchTextBox
		$I->see("Search results for: '" . $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameFillDefaultSimpleProductSkuInSearchTextBox
		$I->comment("Exiting Action Group [fillDefaultSimpleProductSkuInSearchTextBox] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeDefaultProductName] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeDefaultProductName
		$I->see($I->retrieveEntityField('initialSimpleProduct', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeDefaultProductName
		$I->comment("Exiting Action Group [seeDefaultProductName] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Verify customer see simple product with updated name on magento storefront page under store view section");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcher
		$I->waitForPageLoad(30); // stepKey: waitForStoreSwitcherLoad
		$I->click("//div[@class='actions dropdown options switcher-options active']//ul//li//a[contains(text(),'FR" . msq("customStoreFR") . "')]"); // stepKey: clickStoreViewOption
		$I->comment("Entering Action Group [fillDefaultSimpleProductSkuInSearch] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test')); // stepKey: fillInputFillDefaultSimpleProductSkuInSearch
		$I->submitForm("#search", []); // stepKey: submitQuickSearchFillDefaultSimpleProductSkuInSearch
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlFillDefaultSimpleProductSkuInSearch
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyFillDefaultSimpleProductSkuInSearch
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test') . "'"); // stepKey: assertQuickSearchTitleFillDefaultSimpleProductSkuInSearch
		$I->see("Search results for: '" . $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameFillDefaultSimpleProductSkuInSearch
		$I->comment("Exiting Action Group [fillDefaultSimpleProductSkuInSearch] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeUpdatedSimpleProductName] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeUpdatedSimpleProductName
		$I->see("TestSimpleProduct" . msq("simpleProductDataOverriding"), ".product-item-name"); // stepKey: seeProductNameSeeUpdatedSimpleProductName
		$I->comment("Exiting Action Group [seeUpdatedSimpleProductName] StorefrontAssertProductNameOnProductMainPageActionGroup");
	}
}
