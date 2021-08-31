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
 * @Title("MC-12296: Check that New Attribute from Product is create")
 * @Description("Check that New Attribute from Product is create<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateNewAttributeFromProductTest.xml<br>")
 * @TestCaseId("MC-12296")
 * @group Catalog
 */
class AdminCreateNewAttributeFromProductTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete create data");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Delete store views");
		$I->comment("Entering Action Group [deleteFirstStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteFirstStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteFirstStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "EN" . msq("customStoreEN")); // stepKey: fillStoreViewFilterFieldDeleteFirstStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteFirstStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteFirstStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteFirstStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteFirstStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteFirstStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteFirstStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteFirstStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteFirstStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteFirstStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteFirstStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteFirstStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteFirstStoreView
		$I->comment("Exiting Action Group [deleteFirstStoreView] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteSecondStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteSecondStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteSecondStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "FR" . msq("customStoreFR")); // stepKey: fillStoreViewFilterFieldDeleteSecondStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteSecondStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteSecondStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteSecondStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteSecondStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteSecondStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteSecondStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteSecondStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteSecondStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteSecondStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteSecondStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteSecondStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteSecondStoreView
		$I->comment("Exiting Action Group [deleteSecondStoreView] AdminDeleteStoreViewActionGroup");
		$I->comment("Delete Attribute");
		$I->comment("Entering Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "attribute" . msq("productDropDownAttribute")); // stepKey: setAttributeCodeDeleteAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteAttribute
		$I->click("#delete"); // stepKey: deleteAttributeDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteAttributeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteAttribute
		$I->comment("Exiting Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
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
	 * @Stories({"Product attributes"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateNewAttributeFromProductTest(AcceptanceTester $I)
	{
		$I->comment("Create 2 store views");
		$I->comment("Entering Action Group [createFirstStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateFirstStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateFirstStoreView
		$I->fillField("#store_name", "EN" . msq("customStoreEN")); // stepKey: enterStoreViewNameCreateFirstStoreView
		$I->fillField("#store_code", "en" . msq("customStoreEN")); // stepKey: enterStoreViewCodeCreateFirstStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateFirstStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateFirstStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateFirstStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateFirstStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateFirstStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateFirstStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateFirstStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateFirstStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateFirstStoreView
		$I->comment("Exiting Action Group [createFirstStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createSecondStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateSecondStoreView
		$I->fillField("#store_name", "FR" . msq("customStoreFR")); // stepKey: enterStoreViewNameCreateSecondStoreView
		$I->fillField("#store_code", "fr" . msq("customStoreFR")); // stepKey: enterStoreViewCodeCreateSecondStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateSecondStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateSecondStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateSecondStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateSecondStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateSecondStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateSecondStoreView
		$I->comment("Exiting Action Group [createSecondStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Go to created product page and create new attribute");
		$I->comment("Entering Action Group [openAdminEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductOpenAdminEditPage
		$I->comment("Exiting Action Group [openAdminEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [createAttribute] AdminCreateAttributeWithValueWithTwoStoreViesFromProductPageActionGroup");
		$I->click("#addAttribute"); // stepKey: clickAddAttributeBtnCreateAttribute
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeBtnCreateAttributeWaitForPageLoad
		$I->waitForText("Select Attribute", 30); // stepKey: checkNewAttributePopUpAppearedCreateAttribute
		$I->click("//button[@data-index='add_new_attribute_button']"); // stepKey: clickCreateNewAttributeCreateAttribute
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeCreateAttributeWaitForPageLoad
		$I->waitForElementVisible("//input[@name='frontend_label[0]']", 30); // stepKey: waitForAttrLabelCreateAttribute
		$I->waitForPageLoad(30); // stepKey: waitForAttrLabelCreateAttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label[0]']", "attribute" . msq("productDropDownAttribute")); // stepKey: fillAttributeLabelCreateAttribute
		$I->waitForPageLoad(30); // stepKey: fillAttributeLabelCreateAttributeWaitForPageLoad
		$I->selectOption("//select[@name='frontend_input']", "Dropdown"); // stepKey: selectAttributeTypeCreateAttribute
		$I->waitForPageLoad(30); // stepKey: selectAttributeTypeCreateAttributeWaitForPageLoad
		$I->click("//button[@data-action='add_new_row']"); // stepKey: addValueCreateAttribute
		$I->waitForPageLoad(30); // stepKey: addValueCreateAttributeWaitForPageLoad
		$I->seeElement("//table[@data-index='attribute_options_select']//span[contains(text(), 'EN" . msq("customStoreEN") . "')]"); // stepKey: seeFirstStoreViewCreateAttribute
		$I->waitForPageLoad(30); // stepKey: seeFirstStoreViewCreateAttributeWaitForPageLoad
		$I->seeElement("//table[@data-index='attribute_options_select']//span[contains(text(), 'EN" . msq("customStoreEN") . "')]"); // stepKey: seeSecondStoreViewCreateAttribute
		$I->waitForPageLoad(30); // stepKey: seeSecondStoreViewCreateAttributeWaitForPageLoad
		$I->fillField("(//input[contains(@name, 'option[value]')])[1]", "default"); // stepKey: fillDefaultStoreViewCreateAttribute
		$I->waitForPageLoad(30); // stepKey: fillDefaultStoreViewCreateAttributeWaitForPageLoad
		$I->fillField("(//input[contains(@name, 'option[value]')])[2]", "admin"); // stepKey: fillAdminStoreViewCreateAttribute
		$I->waitForPageLoad(30); // stepKey: fillAdminStoreViewCreateAttributeWaitForPageLoad
		$I->fillField("(//input[contains(@name, 'option[value]')])[3]", "view1"); // stepKey: fillFirstStoreViewCreateAttribute
		$I->waitForPageLoad(30); // stepKey: fillFirstStoreViewCreateAttributeWaitForPageLoad
		$I->fillField("(//input[contains(@name, 'option[value]')])[4]", "view2"); // stepKey: fillSecondStoreViewCreateAttribute
		$I->waitForPageLoad(30); // stepKey: fillSecondStoreViewCreateAttributeWaitForPageLoad
		$I->comment("Check store view in Manage Titles section");
		$I->click("//div[@class='fieldset-wrapper-title']//span[contains(text(), 'Manage Titles')]"); // stepKey: openManageTitlesSectionCreateAttribute
		$I->waitForPageLoad(30); // stepKey: openManageTitlesSectionCreateAttributeWaitForPageLoad
		$I->seeElement("//div[@data-index='manage-titles']//span[contains(text(), 'EN" . msq("customStoreEN") . "')]"); // stepKey: seeFirstStoreViewNameCreateAttribute
		$I->waitForPageLoad(30); // stepKey: seeFirstStoreViewNameCreateAttributeWaitForPageLoad
		$I->seeElement("//div[@data-index='manage-titles']//span[contains(text(), 'FR" . msq("customStoreFR") . "')]"); // stepKey: seeSecondStoreViewNameCreateAttribute
		$I->waitForPageLoad(30); // stepKey: seeSecondStoreViewNameCreateAttributeWaitForPageLoad
		$I->click("button#save"); // stepKey: saveAttribute1CreateAttribute
		$I->waitForPageLoad(30); // stepKey: saveAttribute1CreateAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [createAttribute] AdminCreateAttributeWithValueWithTwoStoreViesFromProductPageActionGroup");
		$I->comment("Check attribute existence in product page attribute section");
		$I->conditionalClick("//div[@data-index='attributes']", "//div[@data-index='attributes']/div[contains(@class, 'admin__collapsible-content _show')]", false); // stepKey: openAttributeSection
		$I->waitForPageLoad(30); // stepKey: openAttributeSectionWaitForPageLoad
		$I->seeElement("//select[@name='product[attribute" . msq("productDropDownAttribute") . "]']"); // stepKey: seeNewAttributeInProductPage
		$I->waitForPageLoad(30); // stepKey: seeNewAttributeInProductPageWaitForPageLoad
	}
}
