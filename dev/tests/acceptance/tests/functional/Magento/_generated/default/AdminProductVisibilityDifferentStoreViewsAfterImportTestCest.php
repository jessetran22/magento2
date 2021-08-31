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
 * @Title("MC-6406: Checking product visibility in different store views after product importing")
 * @Description("Checking product visibility in different store views after product importing<h3>Test files</h3>app/code/Magento/ImportExport/Test/Mftf/Test/AdminProductVisibilityDifferentStoreViewsAfterImportTest.xml<br>")
 * @TestCaseId("MC-6406")
 * @group importExport
 */
class AdminProductVisibilityDifferentStoreViewsAfterImportTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create English and Chinese store views");
		$I->comment("Entering Action Group [createEnglishStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateEnglishStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateEnglishStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateEnglishStoreView
		$I->fillField("#store_name", "EN" . msq("customStoreEN")); // stepKey: enterStoreViewNameCreateEnglishStoreView
		$I->fillField("#store_code", "en" . msq("customStoreEN")); // stepKey: enterStoreViewCodeCreateEnglishStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateEnglishStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateEnglishStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateEnglishStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateEnglishStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateEnglishStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateEnglishStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateEnglishStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateEnglishStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateEnglishStoreView
		$I->comment("Exiting Action Group [createEnglishStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createChineseStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateChineseStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateChineseStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateChineseStoreView
		$I->fillField("#store_name", "Chinese"); // stepKey: enterStoreViewNameCreateChineseStoreView
		$I->fillField("#store_code", "chinese"); // stepKey: enterStoreViewCodeCreateChineseStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateChineseStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateChineseStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateChineseStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateChineseStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateChineseStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateChineseStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateChineseStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateChineseStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateChineseStoreView
		$I->comment("Exiting Action Group [createChineseStoreView] AdminCreateStoreViewActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete all imported products");
		$I->comment("Entering Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPage
		$I->comment("Exiting Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [selectNumberOfProductsPerPage] AdminDataGridSelectPerPageActionGroup");
		$I->click(".admin__data-grid-pager-wrap .selectmenu"); // stepKey: clickPerPageDropdownSelectNumberOfProductsPerPage
		$I->click("//div[@class='admin__data-grid-pager-wrap']//div[@class='selectmenu-items _active']//li//button[text()='100']"); // stepKey: selectCustomPerPageSelectNumberOfProductsPerPage
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadSelectNumberOfProductsPerPage
		$I->comment("Exiting Action Group [selectNumberOfProductsPerPage] AdminDataGridSelectPerPageActionGroup");
		$I->comment("Entering Action Group [deleteAllProducts] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteAllProducts
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteAllProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteAllProductsWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteAllProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteAllProducts
		$I->comment("Exiting Action Group [deleteAllProducts] DeleteProductsIfTheyExistActionGroup");
		$I->comment("Delete store views");
		$I->comment("Entering Action Group [deleteEnglishStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteEnglishStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteEnglishStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteEnglishStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteEnglishStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "EN" . msq("customStoreEN")); // stepKey: fillStoreViewFilterFieldDeleteEnglishStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteEnglishStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteEnglishStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteEnglishStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteEnglishStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteEnglishStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteEnglishStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteEnglishStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteEnglishStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteEnglishStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteEnglishStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteEnglishStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteEnglishStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteEnglishStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteEnglishStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteEnglishStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteEnglishStoreView
		$I->comment("Exiting Action Group [deleteEnglishStoreView] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteChineseStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteChineseStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteChineseStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteChineseStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteChineseStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "Chinese"); // stepKey: fillStoreViewFilterFieldDeleteChineseStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteChineseStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteChineseStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteChineseStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteChineseStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteChineseStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteChineseStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteChineseStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteChineseStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteChineseStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteChineseStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteChineseStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteChineseStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteChineseStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteChineseStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteChineseStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteChineseStoreView
		$I->comment("Exiting Action Group [deleteChineseStoreView] AdminDeleteStoreViewActionGroup");
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
	 * @Features({"ImportExport"})
	 * @Stories({"Import Products"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductVisibilityDifferentStoreViewsAfterImportTest(AcceptanceTester $I)
	{
		$I->comment("Import products from file");
		$I->comment("Entering Action Group [importProducts] AdminImportProductsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageImportProducts
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadImportProducts
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionImportProducts
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleImportProducts
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionImportProducts
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionImportProducts
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldImportProducts
		$I->attachFile("#import_file", "import_productsoftwostoresdata.csv"); // stepKey: attachFileForImportImportProducts
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonImportProducts
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonImportProductsWaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonImportProducts
		$I->waitForPageLoad(30); // stepKey: clickImportButtonImportProductsWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageImportProducts
		$I->see("Created: 2, Updated: 0, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageImportProducts
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageImportProducts
		$I->comment("Exiting Action Group [importProducts] AdminImportProductsActionGroup");
		$I->comment("Open imported name4 product");
		$I->comment("Entering Action Group [openName4Product] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageOpenName4Product
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenName4Product
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenName4Product
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenName4ProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenName4Product
		$I->fillField("input.admin__control-text[name='sku']", "name4"); // stepKey: fillProductSkuFilterOpenName4Product
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenName4Product
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenName4ProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadOpenName4Product
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='name4']]"); // stepKey: openSelectedProductOpenName4Product
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadOpenName4Product
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleOpenName4Product
		$I->comment("Exiting Action Group [openName4Product] FilterAndSelectProductActionGroup");
		$I->comment("Switch Chinese store view and assert visibility field");
		$I->comment("Switch Chinese store view and assert visibility field");
		$I->comment("Entering Action Group [switchToCustomStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchToCustomStoreView
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchToCustomStoreView
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchToCustomStoreViewWaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchToCustomStoreView
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchToCustomStoreViewWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='Chinese']"); // stepKey: chooseStoreViewSwitchToCustomStoreView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchToCustomStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchToCustomStoreView
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchToCustomStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToCustomStoreView
		$I->comment("Exiting Action Group [switchToCustomStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->seeInField("//select[@name='product[visibility]']", "Catalog"); // stepKey: seeVisibilityFieldForChineseStore
		$I->comment("Switch English store view and assert visibility field");
		$I->comment("Entering Action Group [switchToCustomEnglishView] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchToCustomEnglishView
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchToCustomEnglishView
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchToCustomEnglishViewWaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchToCustomEnglishView
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchToCustomEnglishViewWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='EN" . msq("customStoreEN") . "']"); // stepKey: chooseStoreViewSwitchToCustomEnglishView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchToCustomEnglishViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchToCustomEnglishView
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchToCustomEnglishViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToCustomEnglishView
		$I->comment("Exiting Action Group [switchToCustomEnglishView] SwitchToTheNewStoreViewActionGroup");
		$I->seeInField("//select[@name='product[visibility]']", "Catalog"); // stepKey: seeVisibilityFieldForEnglishView
	}
}
