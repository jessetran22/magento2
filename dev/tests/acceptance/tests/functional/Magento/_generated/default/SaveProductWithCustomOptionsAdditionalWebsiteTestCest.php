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
 * @Title("MC-25687: You should be able to save a product with custom options assigned to a different website")
 * @Description("Custom Options should not be split when saving the product after assigning to a different website<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/SaveProductWithCustomOptionsSecondWebsiteTest.xml<br>")
 * @TestCaseId("MC-25687")
 * @group product
 */
class SaveProductWithCustomOptionsAdditionalWebsiteTestCest
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
		$I->comment("Entering Action Group [createAdditionalWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateAdditionalWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateAdditionalWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateAdditionalWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateAdditionalWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateAdditionalWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateAdditionalWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateAdditionalWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateAdditionalWebsite
		$I->comment("Exiting Action Group [createAdditionalWebsite] AdminCreateWebsiteActionGroup");
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
		$I->comment("Entering Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateNewStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateNewStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateNewStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateNewStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateNewStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateNewStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateNewStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateNewStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateNewStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateNewStoreView
		$I->comment("Exiting Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [addStoreCodeToUrls] EnableWebUrlOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPageAddStoreCodeToUrls
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddStoreCodeToUrls
		$I->conditionalClick("#web_url-head", "#web_url-head:not(.open)", true); // stepKey: expandUrlSectionTabAddStoreCodeToUrls
		$I->waitForElementVisible("#web_url_use_store", 30); // stepKey: seeAddStoreCodeToUrlAddStoreCodeToUrls
		$I->uncheckOption("#web_url_use_store_inherit"); // stepKey: uncheckUseSystemValueAddStoreCodeToUrls
		$I->selectOption("#web_url_use_store", "Yes"); // stepKey: enableStoreCodeAddStoreCodeToUrls
		$I->click("#web_url-head"); // stepKey: collapseUrlOptionsAddStoreCodeToUrls
		$I->click("#save"); // stepKey: saveConfigAddStoreCodeToUrls
		$I->waitForPageLoad(30); // stepKey: saveConfigAddStoreCodeToUrlsWaitForPageLoad
		$I->comment("Exiting Action Group [addStoreCodeToUrls] EnableWebUrlOptionsActionGroup");
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
		$I->comment("Entering Action Group [deleteTestWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteTestWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteTestWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteTestWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteTestWebsiteWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteTestWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteTestWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteTestWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteTestWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteTestWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteTestWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteTestWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteTestWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteTestWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteTestWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Stories({"Purchase a product with Custom Options of different types"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function SaveProductWithCustomOptionsAdditionalWebsiteTest(AcceptanceTester $I)
	{
		$I->comment("Create a Simple Product with Custom Options");
		$I->comment("Entering Action Group [navigateToCatalogProductGrid] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToCatalogProductGrid
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToCatalogProductGrid
		$I->comment("Exiting Action Group [navigateToCatalogProductGrid] AdminOpenProductIndexPageActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownClickAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownClickAddSimpleProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductClickAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadClickAddSimpleProduct
		$I->comment("Exiting Action Group [clickAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillName
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKU
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPrice
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantity
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: clickIfContentTabCloses2
		$I->waitForPageLoad(30); // stepKey: clickIfContentTabCloses2WaitForPageLoad
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOption
		$I->waitForPageLoad(30); // stepKey: clickAddOptionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitAfterAddOption
		$I->fillField("input[name='product[options][0][title]']", "Radio Option"); // stepKey: fillOptionTitle
		$I->click(".admin__dynamic-rows[data-index='options'] .action-select"); // stepKey: openOptionTypeDropDown
		$I->click(".admin__dynamic-rows[data-index='options'] .action-menu._active li:nth-of-type(3) li:nth-of-type(2)"); // stepKey: selectRadioButtonType
		$I->comment("Add Option Values");
		$I->click("//span[text()='Radio Option']/parent::div/parent::div/parent::div//tfoot//button"); // stepKey: clickAddValue1
		$I->fillField("//span[text()='Radio Option']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "option 1"); // stepKey: fillOptionValueTitle1
		$I->fillField("//span[text()='Radio Option']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "5"); // stepKey: fillOptionValuePrice1
		$I->click("//span[text()='Radio Option']/parent::div/parent::div/parent::div//tfoot//button"); // stepKey: clickAddValue2
		$I->fillField("//span[text()='Radio Option']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "option 2"); // stepKey: fillOptionValueTitle2
		$I->fillField("//span[text()='Radio Option']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "6"); // stepKey: fillOptionValuePrice2
		$I->click("//span[text()='Radio Option']/parent::div/parent::div/parent::div//tfoot//button"); // stepKey: clickAddValue3
		$I->fillField("//span[text()='Radio Option']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='2']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "option 3"); // stepKey: fillOptionValueTitle3
		$I->fillField("//span[text()='Radio Option']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='2']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "7"); // stepKey: fillOptionValuePrice3
		$I->comment("Save the product with custom options");
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->seeElement(".message.message-success.success"); // stepKey: seeProductSavedMessage
		$I->comment("Add this product to second website");
		$I->click("div[data-index='websites']"); // stepKey: openProductInWebsitesSection1
		$I->waitForPageLoad(30); // stepKey: openProductInWebsitesSection1WaitForPageLoad
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectSecondWebsite
		$I->click("#save-button"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForProductPagetoSaveAgain
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageAgain
		$I->click("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']"); // stepKey: openCustomOptionsSection2
		$I->seeNumberOfElements(".admin__dynamic-rows[data-index='values'] tr.data-row", "3"); // stepKey: see4RowsOfOptions
	}
}
