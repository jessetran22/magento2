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
 * @Title("MC-11466: Delete products image in case of multiple stores")
 * @Description("Delete products image in case of multiple stores<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminDeleteProductsImageInCaseOfMultipleStoresTest.xml<br>")
 * @TestCaseId("MC-11466")
 * @group Catalog
 */
class AdminDeleteProductsImageInCaseOfMultipleStoresTestCest
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
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create new website, store and store view");
		$I->comment("Entering Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "WebSite" . msq("NewWebSiteData")); // stepKey: enterWebsiteNameCreateWebsite
		$I->fillField("#website_code", "WebSiteCode" . msq("NewWebSiteData")); // stepKey: enterWebsiteCodeCreateWebsite
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
		$I->selectOption("#group_website_id", "WebSite" . msq("NewWebSiteData")); // stepKey: selectWebsiteCreateNewStore
		$I->fillField("#group_name", "Store" . msq("NewStoreData")); // stepKey: enterStoreGroupNameCreateNewStore
		$I->fillField("#group_code", "StoreCode" . msq("NewStoreData")); // stepKey: enterStoreGroupCodeCreateNewStore
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
		$I->selectOption("#store_group_id", "Store" . msq("NewStoreData")); // stepKey: selectStoreCreateCustomStoreView
		$I->fillField("#store_name", "StoreView" . msq("NewStoreViewData")); // stepKey: enterStoreViewNameCreateCustomStoreView
		$I->fillField("#store_code", "StoreViewCode" . msq("NewStoreViewData")); // stepKey: enterStoreViewCodeCreateCustomStoreView
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
		$I->comment("Create Product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->createEntity("createSubCategory", "hook", "SubCategory", [], []); // stepKey: createSubCategory
		$I->createEntity("createRootCategory", "hook", "NewRootCategory", [], []); // stepKey: createRootCategory
		$I->comment("Entering Action Group [visitAdminProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'hook')); // stepKey: goToProductVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad0
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", ['Default Category', $I->retrieveEntityField('createRootCategory', 'name', 'hook'), $I->retrieveEntityField('createSubCategory', 'name', 'hook')]); // stepKey: fillCategory
		$I->waitForPageLoad(30); // stepKey: fillCategoryWaitForPageLoad
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
		$I->comment("Add images to the product");
		$I->comment("Entering Action Group [visitAdminProductPage2] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'hook')); // stepKey: goToProductVisitAdminProductPage2
		$I->comment("Exiting Action Group [visitAdminProductPage2] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad1
		$I->comment("Entering Action Group [addImageToProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddImageToProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddImageToProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddImageToProduct
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddImageToProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageToProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImageToProduct
		$I->comment("Exiting Action Group [addImageToProduct] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addImage1ToProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddImage1ToProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddImage1ToProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddImage1ToProduct
		$I->attachFile("#fileupload", "magento-again.jpg"); // stepKey: uploadFileAddImage1ToProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImage1ToProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddImage1ToProduct
		$I->comment("Exiting Action Group [addImage1ToProduct] AddProductImageActionGroup");
		$I->comment("Entering Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct1
		$I->comment("Exiting Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->comment("Enable config to view created store view on store front");
		$I->createEntity("enableWebUrlOptionsConfig", "hook", "EnableWebUrlOptionsConfig", [], []); // stepKey: enableWebUrlOptionsConfig
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "WebSite" . msq("NewWebSiteData")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("WebSite" . msq("NewWebSiteData"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
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
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->deleteEntity("createSubCategory", "hook"); // stepKey: deleteSubCategory
		$I->deleteEntity("createRootCategory", "hook"); // stepKey: deleteRootCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->createEntity("defaultWebUrlOptionsConfig", "hook", "DefaultWebUrlOptionsConfig", [], []); // stepKey: defaultWebUrlOptionsConfig
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
	 * @Stories({"MultipleStores"})
	 * @Features({"Catalog"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteProductsImageInCaseOfMultipleStoresTest(AcceptanceTester $I)
	{
		$I->comment("Grab new store view code");
		$I->comment("Entering Action Group [navigateToNewWebsitePage] AdminSystemStoreOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToSystemStoreNavigateToNewWebsitePage
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminSystemStoreLoadNavigateToNewWebsitePage
		$I->comment("Exiting Action Group [navigateToNewWebsitePage] AdminSystemStoreOpenPageActionGroup");
		$I->fillField("#storeGrid_filter_website_title", "WebSite" . msq("NewWebSiteData")); // stepKey: fillSearchWebsiteField
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButton
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickFirstRow
		$grabStoreViewCode = $I->grabValueFrom("#store_code"); // stepKey: grabStoreViewCode
		$I->click("#back"); // stepKey: clickBack
		$I->waitForPageLoad(30); // stepKey: clickBackWaitForPageLoad
		$I->click("button[title='Reset Filter']"); // stepKey: clickResetButton
		$I->waitForPageLoad(30); // stepKey: clickResetButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStorePageLoad
		$I->comment("Open product page on admin");
		$I->comment("Entering Action Group [openProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductOpenProductEditPage
		$I->comment("Exiting Action Group [openProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad2
		$I->comment("Enable the newly created website and save the product");
		$I->comment("Entering Action Group [selectWebsiteInProduct2] SelectProductInWebsitesActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSelectWebsiteInProduct2
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSelectWebsiteInProduct2WaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "div[data-index='content']._show", false); // stepKey: expandSectionSelectWebsiteInProduct2
		$I->waitForPageLoad(30); // stepKey: expandSectionSelectWebsiteInProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedSelectWebsiteInProduct2
		$I->checkOption("//label[contains(text(), 'WebSite" . msq("NewWebSiteData") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteSelectWebsiteInProduct2
		$I->comment("Exiting Action Group [selectWebsiteInProduct2] SelectProductInWebsitesActionGroup");
		$I->comment("Entering Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct2
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct2
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct2
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct2WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct2
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct2
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct2
		$I->comment("Exiting Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Switch to 'Default Store View' scope and open product page");
		$I->comment("Entering Action Group [SwitchDefaultStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchDefaultStoreView
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchDefaultStoreView
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchDefaultStoreViewWaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchDefaultStoreView
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchDefaultStoreViewWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='Default Store View']"); // stepKey: chooseStoreViewSwitchDefaultStoreView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchDefaultStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchDefaultStoreView
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchDefaultStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchDefaultStoreView
		$I->comment("Exiting Action Group [SwitchDefaultStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad3
		$I->comment("Assign all roles to first image on default store view");
		$I->comment("Entering Action Group [assignAllRolesToFirstImage] AdminAssignImageRolesIfUnassignedActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", false); // stepKey: expandImagesAssignAllRolesToFirstImage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeProductImageNameAssignAllRolesToFirstImage
		$I->click("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]"); // stepKey: clickProductImageAssignAllRolesToFirstImage
		$I->waitForElementVisible("textarea[data-role='image-description']", 30); // stepKey: seeAltTextSectionAssignAllRolesToFirstImage
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleBaseAssignAllRolesToFirstImage
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleSmallAssignAllRolesToFirstImage
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleThumbnailAssignAllRolesToFirstImage
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleSwatchAssignAllRolesToFirstImage
		$I->click(".modal-slide._show [data-role=\"closeBtn\"]"); // stepKey: clickCloseButtonAssignAllRolesToFirstImage
		$I->waitForPageLoad(30); // stepKey: clickCloseButtonAssignAllRolesToFirstImageWaitForPageLoad
		$I->comment("Exiting Action Group [assignAllRolesToFirstImage] AdminAssignImageRolesIfUnassignedActionGroup");
		$I->comment("Entering Action Group [saveProduct3] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct3
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct3
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct3WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct3
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct3WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct3
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct3
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct3
		$I->comment("Exiting Action Group [saveProduct3] SaveProductFormActionGroup");
		$I->comment("Switch to newly created Store View scope and open product page");
		$I->comment("Entering Action Group [SwitchNewStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchNewStoreView
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchNewStoreView
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchNewStoreViewWaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchNewStoreView
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchNewStoreViewWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='StoreView" . msq("NewStoreViewData") . "']"); // stepKey: chooseStoreViewSwitchNewStoreView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchNewStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchNewStoreView
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchNewStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchNewStoreView
		$I->comment("Exiting Action Group [SwitchNewStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad4
		$I->comment("Assign all roles to first image on new store view");
		$I->comment("Entering Action Group [assignAllRolesToFirstImage2] AdminAssignImageRolesIfUnassignedActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", false); // stepKey: expandImagesAssignAllRolesToFirstImage2
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeProductImageNameAssignAllRolesToFirstImage2
		$I->click("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]"); // stepKey: clickProductImageAssignAllRolesToFirstImage2
		$I->waitForElementVisible("textarea[data-role='image-description']", 30); // stepKey: seeAltTextSectionAssignAllRolesToFirstImage2
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleBaseAssignAllRolesToFirstImage2
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleSmallAssignAllRolesToFirstImage2
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleThumbnailAssignAllRolesToFirstImage2
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleSwatchAssignAllRolesToFirstImage2
		$I->click(".modal-slide._show [data-role=\"closeBtn\"]"); // stepKey: clickCloseButtonAssignAllRolesToFirstImage2
		$I->waitForPageLoad(30); // stepKey: clickCloseButtonAssignAllRolesToFirstImage2WaitForPageLoad
		$I->comment("Exiting Action Group [assignAllRolesToFirstImage2] AdminAssignImageRolesIfUnassignedActionGroup");
		$I->comment("Entering Action Group [saveProduct4] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct4
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct4
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct4WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct4
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct4WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct4
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct4
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct4
		$I->comment("Exiting Action Group [saveProduct4] SaveProductFormActionGroup");
		$I->comment("Switch to 'All Store Views' scope and open product page");
		$I->comment("Entering Action Group [SwitchAllStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchAllStoreView
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchAllStoreView
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchAllStoreViewWaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchAllStoreView
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchAllStoreViewWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='All Store Views']"); // stepKey: chooseStoreViewSwitchAllStoreView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchAllStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchAllStoreView
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchAllStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchAllStoreView
		$I->comment("Exiting Action Group [SwitchAllStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad5
		$I->comment("Remove product image and save");
		$I->comment("Entering Action Group [removeProductImage] RemoveProductImageByNameActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionRemoveProductImage
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshRemoveProductImage
		$I->click("[id='media_gallery_content'] img[src*='magento-logo'] + div[class='actions']  button[class='action-remove']"); // stepKey: clickRemoveImageRemoveProductImage
		$I->comment("Exiting Action Group [removeProductImage] RemoveProductImageByNameActionGroup");
		$I->comment("Entering Action Group [saveProduct5] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct5
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct5
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct5WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct5
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct5WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct5
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct5
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct5
		$I->comment("Exiting Action Group [saveProduct5] SaveProductFormActionGroup");
		$I->comment("Assert notification and success messages");
		$I->see("You saved the product.", "div.message-success.success.message"); // stepKey: seeSuccessMessage
		$I->see("The image cannot be removed as it has been assigned to the other image role", "div.message.notice div"); // stepKey: seeNotification
		$I->comment("Reopen image tab and see the image is not deleted");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesTab
		$I->waitForPageLoad(30); // stepKey: waitForImagesLoad
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]"); // stepKey: seeImageIsNotDeleted
		$I->comment("Switch to newly created Store View scope and open product page");
		$I->comment("Entering Action Group [SwitchNewStoreView2] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchNewStoreView2
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchNewStoreView2
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchNewStoreView2WaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchNewStoreView2
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchNewStoreView2WaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='StoreView" . msq("NewStoreViewData") . "']"); // stepKey: chooseStoreViewSwitchNewStoreView2
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchNewStoreView2WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchNewStoreView2
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchNewStoreView2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchNewStoreView2
		$I->comment("Exiting Action Group [SwitchNewStoreView2] SwitchToTheNewStoreViewActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad6
		$I->comment("Assign all roles to second image on default store view");
		$I->comment("Entering Action Group [assignAllRolesToSecondImage] AdminAssignImageRolesIfUnassignedActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", false); // stepKey: expandImagesAssignAllRolesToSecondImage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: seeProductImageNameAssignAllRolesToSecondImage
		$I->click("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]"); // stepKey: clickProductImageAssignAllRolesToSecondImage
		$I->waitForElementVisible("textarea[data-role='image-description']", 30); // stepKey: seeAltTextSectionAssignAllRolesToSecondImage
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleBaseAssignAllRolesToSecondImage
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleSmallAssignAllRolesToSecondImage
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleThumbnailAssignAllRolesToSecondImage
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleSwatchAssignAllRolesToSecondImage
		$I->click(".modal-slide._show [data-role=\"closeBtn\"]"); // stepKey: clickCloseButtonAssignAllRolesToSecondImage
		$I->waitForPageLoad(30); // stepKey: clickCloseButtonAssignAllRolesToSecondImageWaitForPageLoad
		$I->comment("Exiting Action Group [assignAllRolesToSecondImage] AdminAssignImageRolesIfUnassignedActionGroup");
		$I->comment("Entering Action Group [saveProduct6] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct6
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct6
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct6WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct6
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct6WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct6
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct6
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct6
		$I->comment("Exiting Action Group [saveProduct6] SaveProductFormActionGroup");
		$I->comment("Switch to 'All Store Views' scope and open product page");
		$I->comment("Entering Action Group [SwitchAllStoreView2] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchAllStoreView2
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchAllStoreView2
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchAllStoreView2WaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchAllStoreView2
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchAllStoreView2WaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='All Store Views']"); // stepKey: chooseStoreViewSwitchAllStoreView2
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchAllStoreView2WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchAllStoreView2
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchAllStoreView2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchAllStoreView2
		$I->comment("Exiting Action Group [SwitchAllStoreView2] SwitchToTheNewStoreViewActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad7
		$I->comment("Remove product image and save");
		$I->comment("Entering Action Group [removeProductFirstImage] RemoveProductImageByNameActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionRemoveProductFirstImage
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshRemoveProductFirstImage
		$I->click("[id='media_gallery_content'] img[src*='magento-logo'] + div[class='actions']  button[class='action-remove']"); // stepKey: clickRemoveImageRemoveProductFirstImage
		$I->comment("Exiting Action Group [removeProductFirstImage] RemoveProductImageByNameActionGroup");
		$I->comment("Entering Action Group [saveProduct7] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct7
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct7
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct7WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct7
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct7WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct7
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct7
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct7
		$I->comment("Exiting Action Group [saveProduct7] SaveProductFormActionGroup");
		$I->comment("Assert notification and success messages");
		$I->see("You saved the product.", "div.message-success.success.message"); // stepKey: seeSuccessMessage2
		$I->see("The image cannot be removed as it has been assigned to the other image role", "div.message.notice div"); // stepKey: seeNotification2
		$I->comment("Reopen image tab and see the image is not deleted");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesTab2
		$I->waitForPageLoad(30); // stepKey: waitForImagesLoad2
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]"); // stepKey: seeImageIsNotDeleted2
		$I->comment("Switch to newly created Store View scope and open product page");
		$I->comment("Entering Action Group [SwitchNewStoreView3] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchNewStoreView3
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchNewStoreView3
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchNewStoreView3WaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchNewStoreView3
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchNewStoreView3WaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='StoreView" . msq("NewStoreViewData") . "']"); // stepKey: chooseStoreViewSwitchNewStoreView3
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchNewStoreView3WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchNewStoreView3
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchNewStoreView3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchNewStoreView3
		$I->comment("Exiting Action Group [SwitchNewStoreView3] SwitchToTheNewStoreViewActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad8
		$I->comment("Remove second image and save");
		$I->comment("Entering Action Group [removeProductSecondImage] RemoveProductImageByNameActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionRemoveProductSecondImage
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshRemoveProductSecondImage
		$I->click("[id='media_gallery_content'] img[src*='magento-again'] + div[class='actions']  button[class='action-remove']"); // stepKey: clickRemoveImageRemoveProductSecondImage
		$I->comment("Exiting Action Group [removeProductSecondImage] RemoveProductImageByNameActionGroup");
		$I->comment("Entering Action Group [saveProduct8] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct8
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct8
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct8WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct8
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct8WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct8
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct8
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct8
		$I->comment("Exiting Action Group [saveProduct8] SaveProductFormActionGroup");
		$I->comment("Assert success messages");
		$I->see("You saved the product.", "div.message-success.success.message"); // stepKey: seeSuccessMessage3
		$I->comment("Reopen image tab and see the image is deleted");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesTab3
		$I->waitForPageLoad(30); // stepKey: waitForImagesLoad3
		$I->dontSeeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]"); // stepKey: seeImageIsDeleted
		$I->comment("Open Storefront on Default store view and assert image existence");
		$I->amOnPage("/" . $I->retrieveEntityField('createSubCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad0
		$grabAttributeFromImage = $I->grabAttributeFrom("img[alt='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']", "src"); // stepKey: grabAttributeFromImage
		$I->assertStringContainsString("magento-logo", $grabAttributeFromImage); // stepKey: assertProductImageAbsence
		$I->comment("Open Storefront on newly created store view and assert image absence");
		$I->amOnPage("$grabStoreViewCode"); // stepKey: navigateToHomePageOfSpecificStore
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createSubCategory', 'name', 'test') . "')]]"); // stepKey: clickCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad1
		$grabAttributeFromImage2 = $I->grabAttributeFrom("img[alt='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']", "src"); // stepKey: grabAttributeFromImage2
		$I->assertStringContainsString("small_image", $grabAttributeFromImage2); // stepKey: assertProductImageAbsence2
	}
}
