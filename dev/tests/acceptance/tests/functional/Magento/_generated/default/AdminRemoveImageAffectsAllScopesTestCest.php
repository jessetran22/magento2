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
 * @Title("MAGETWO-94265: Effect of product images changes in default scope to other scopes")
 * @Description("Product image should be deleted from all scopes<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminRemoveImageAffectsAllScopesTest.xml<br>")
 * @TestCaseId("MAGETWO-94265")
 * @group Catalog
 */
class AdminRemoveImageAffectsAllScopesTestCest
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
		$I->comment("Create 2 websites (with stores, store views)");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "_defaultProduct", ["category"], []); // stepKey: product
		$I->comment("Entering Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateWebsite
		$I->comment("Exiting Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateNewStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectWebsiteCreateNewStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameCreateNewStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeCreateNewStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateNewStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewStore
		$I->comment("Exiting Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateCustomStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateCustomStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateCustomStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateCustomStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateCustomStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateCustomStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateCustomStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateCustomStoreView
		$I->comment("Exiting Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createSecondWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateSecondWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateSecondWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Custom Website" . msq("secondCustomWebsite")); // stepKey: enterWebsiteNameCreateSecondWebsite
		$I->fillField("#website_code", "custom_website" . msq("secondCustomWebsite")); // stepKey: enterWebsiteCodeCreateSecondWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateSecondWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateSecondWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateSecondWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateSecondWebsite
		$I->comment("Exiting Action Group [createSecondWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [createSecondStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateSecondStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Custom Website" . msq("secondCustomWebsite")); // stepKey: selectWebsiteCreateSecondStore
		$I->fillField("#group_name", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupNameCreateSecondStore
		$I->fillField("#group_code", "second_store_" . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupCodeCreateSecondStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateSecondStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateSecondStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateSecondStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateSecondStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateSecondStore
		$I->comment("Exiting Action Group [createSecondStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [createCustomStoreView2] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateCustomStoreView2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateCustomStoreView2
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: selectStoreCreateCustomStoreView2
		$I->fillField("#store_name", "Second Store View " . msq("SecondStoreUnique")); // stepKey: enterStoreViewNameCreateCustomStoreView2
		$I->fillField("#store_code", "second_store_view_" . msq("SecondStoreUnique")); // stepKey: enterStoreViewCodeCreateCustomStoreView2
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateCustomStoreView2
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateCustomStoreView2
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateCustomStoreView2WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateCustomStoreView2
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateCustomStoreView2WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateCustomStoreView2
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateCustomStoreView2
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateCustomStoreView2WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateCustomStoreView2
		$I->comment("Exiting Action Group [createCustomStoreView2] AdminCreateStoreViewActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [resetUrlOption] ResetWebUrlOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPagetoResetResetUrlOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2ResetUrlOption
		$I->conditionalClick("#web_url-head", "#web_url-head:not(.open)", true); // stepKey: closeUrlSectionTabResetUrlOption
		$I->waitForElementVisible("#web_url_use_store", 30); // stepKey: seeAddStoreCodeToUrl2ResetUrlOption
		$I->comment("<uncheckOption selector=\"\{\{UrlOptionsSection.systemValueForStoreCode\}\}\" stepKey=\"uncheckUseSystemValue\"/>");
		$I->selectOption("#web_url_use_store", "No"); // stepKey: enableStoreCodeResetUrlOption
		$I->checkOption("#web_url_use_store_inherit"); // stepKey: checkUseSystemValueResetUrlOption
		$I->click("#web_url-head"); // stepKey: collapseUrlOptionsResetUrlOption
		$I->click("#save"); // stepKey: saveConfigResetUrlOption
		$I->waitForPageLoad(30); // stepKey: saveConfigResetUrlOptionWaitForPageLoad
		$I->comment("Exiting Action Group [resetUrlOption] ResetWebUrlOptionsActionGroup");
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Entering Action Group [deleteSecondWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteSecondWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteSecondWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Custom Website" . msq("secondCustomWebsite")); // stepKey: fillSearchWebsiteFieldDeleteSecondWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteSecondWebsiteWaitForPageLoad
		$I->see("Custom Website" . msq("secondCustomWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteSecondWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteSecondWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteSecondWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteSecondWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteSecondWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteSecondWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteSecondWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteSecondWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteSecondWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteSecondWebsite] AdminDeleteWebsiteActionGroup");
		$I->deleteEntity("category", "hook"); // stepKey: deletePreReqCategory
		$I->deleteEntity("product", "hook"); // stepKey: deleteFirstProduct
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Features({"Catalog"})
	 * @Stories({"MAGETWO-66442: Changes in default scope not effect product images in other scopes"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminRemoveImageAffectsAllScopesTest(AcceptanceTester $I)
	{
		$I->comment("Create product");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridColumnsInitialWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridColumnsInitial
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitialWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridColumnsInitial
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridColumnsInitial
		$I->comment("Exiting Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Open created product");
		$I->click("//tbody//tr//td//div[contains(., '" . $I->retrieveEntityField('product', 'name', 'test') . "')]"); // stepKey: createdProduct
		$I->waitForPageLoad(30); // stepKey: createdProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOpenedCreatedProduct
		$I->comment("Add image to product");
		$I->comment("Entering Action Group [addFirstImageForProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddFirstImageForProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddFirstImageForProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddFirstImageForProduct
		$I->attachFile("#fileupload", "magento-again.jpg"); // stepKey: uploadFileAddFirstImageForProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddFirstImageForProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddFirstImageForProduct
		$I->comment("Exiting Action Group [addFirstImageForProduct] AddProductImageActionGroup");
		$I->comment("Add second image to product");
		$I->comment("Entering Action Group [addSecondImageForProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddSecondImageForProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddSecondImageForProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddSecondImageForProduct
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddSecondImageForProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddSecondImageForProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddSecondImageForProduct
		$I->comment("Exiting Action Group [addSecondImageForProduct] AddProductImageActionGroup");
		$I->comment("\"Product in Websites\": select both Websites");
		$I->comment("Entering Action Group [ProductSetWebsite1] ProductSetWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesProductSetWebsite1
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesProductSetWebsite1WaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']", false); // stepKey: clickToOpenProductInWebsiteProductSetWebsite1
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedProductSetWebsite1
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteProductSetWebsite1
		$I->click("#save-button"); // stepKey: clickSaveProductProductSetWebsite1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductProductSetWebsite1WaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: waitForProducrSavedProductSetWebsite1
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSaveSuccessMessageProductSetWebsite1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveSuccessMessageProductSetWebsite1
		$I->comment("Exiting Action Group [ProductSetWebsite1] ProductSetWebsiteActionGroup");
		$I->comment("Entering Action Group [ProductSetWebsite2] ProductSetWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesProductSetWebsite2
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesProductSetWebsite2WaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "//label[contains(text(), 'Custom Website" . msq("secondCustomWebsite") . "')]/parent::div//input[@type='checkbox']", false); // stepKey: clickToOpenProductInWebsiteProductSetWebsite2
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedProductSetWebsite2
		$I->click("//label[contains(text(), 'Custom Website" . msq("secondCustomWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteProductSetWebsite2
		$I->click("#save-button"); // stepKey: clickSaveProductProductSetWebsite2
		$I->waitForPageLoad(30); // stepKey: clickSaveProductProductSetWebsite2WaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: waitForProducrSavedProductSetWebsite2
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSaveSuccessMessageProductSetWebsite2
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveSuccessMessageProductSetWebsite2
		$I->comment("Exiting Action Group [ProductSetWebsite2] ProductSetWebsiteActionGroup");
		$I->comment("Go to \"Catalog\" -> \"Products\". Open created product");
		$I->comment("Entering Action Group [navigateToProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductPage
		$I->comment("Exiting Action Group [navigateToProductPage] AdminOpenProductIndexPageActionGroup");
		$I->click("//tbody//tr//td//div[contains(., '" . $I->retrieveEntityField('product', 'name', 'test') . "')]"); // stepKey: openCreatedProduct
		$I->waitForPageLoad(30); // stepKey: openCreatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreatedProductOpened
		$I->comment("Delete Image 1");
		$I->comment("Entering Action Group [removeProductImage] RemoveProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionRemoveProductImage
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshRemoveProductImage
		$I->click(".action-remove"); // stepKey: clickRemoveImageRemoveProductImage
		$I->comment("Exiting Action Group [removeProductImage] RemoveProductImageActionGroup");
		$I->comment("Click \"Save\" in the upper right corner");
		$I->comment("Entering Action Group [saveProductFormAfterRemove] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductFormAfterRemove
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductFormAfterRemove
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormAfterRemoveWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductFormAfterRemove
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormAfterRemoveWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductFormAfterRemove
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductFormAfterRemove
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductFormAfterRemove
		$I->comment("Exiting Action Group [saveProductFormAfterRemove] SaveProductFormActionGroup");
		$I->comment("Switch to \"Store view 1\"");
		$I->comment("Entering Action Group [selectStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSelectStoreView
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSelectStoreView
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSelectStoreViewWaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSelectStoreView
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSelectStoreViewWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='store" . msq("customStore") . "']"); // stepKey: chooseStoreViewSelectStoreView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSelectStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSelectStoreView
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSelectStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectStoreView
		$I->comment("Exiting Action Group [selectStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->comment("Assert product first image not in admin product form");
		$I->comment("Entering Action Group [assertProductImageNotInAdminProductPage] AssertProductImageNotInAdminProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProductImageNotInAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageNotInAdminProductPage
		$I->dontSeeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]"); // stepKey: seeImageAssertProductImageNotInAdminProductPage
		$I->comment("Exiting Action Group [assertProductImageNotInAdminProductPage] AssertProductImageNotInAdminProductPageActionGroup");
		$I->comment("Switch to \"Store view 2\"");
		$I->comment("Entering Action Group [selectSecondStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSelectSecondStoreView
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSelectSecondStoreView
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSelectSecondStoreViewWaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSelectSecondStoreView
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSelectSecondStoreViewWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='Second Store View " . msq("SecondStoreUnique") . "']"); // stepKey: chooseStoreViewSelectSecondStoreView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSelectSecondStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSelectSecondStoreView
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSelectSecondStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectSecondStoreView
		$I->comment("Exiting Action Group [selectSecondStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->comment("Verify that Image 1 is deleted from the Second Store View list");
		$I->comment("Entering Action Group [assertProductImageNotInSecondStoreViewPage] AssertProductImageNotInAdminProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProductImageNotInSecondStoreViewPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageNotInSecondStoreViewPage
		$I->dontSeeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]"); // stepKey: seeImageAssertProductImageNotInSecondStoreViewPage
		$I->comment("Exiting Action Group [assertProductImageNotInSecondStoreViewPage] AssertProductImageNotInAdminProductPageActionGroup");
	}
}
