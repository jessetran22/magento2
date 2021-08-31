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
 * @Title("MC-40644: Product grid date filters does not work for en_GB locale")
 * @Description("Product grid date filters does not work for en_GB locale<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminProductGridFilteringByDateWithCustomLocaleTest.xml<br>")
 * @TestCaseId("MC-40644")
 * @group catalog
 */
class AdminProductGridFilteringByDateWithCustomLocaleTestCest
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
		$I->comment("Deploy static content with United Kingdom locale");
		$deployStaticContentWithUnitedKingdomLocale = $I->magentoCLI("setup:static-content:deploy en_GB", 60); // stepKey: deployStaticContentWithUnitedKingdomLocale
		$I->comment($deployStaticContentWithUnitedKingdomLocale);
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Create new User");
		$I->comment("Entering Action Group [adminLogin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameAdminLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordAdminLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginAdminLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginAdminLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleAdminLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationAdminLogin
		$I->comment("Exiting Action Group [adminLogin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createAdminUser] AdminCreateUserWithRoleAndLocaleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: navigateToNewUserCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForUsersPageCreateAdminUser
		$I->fillField("#user_username", "AdminUser" . msq("activeAdmin")); // stepKey: enterUserNameCreateAdminUser
		$I->fillField("#user_firstname", "FirstName" . msq("activeAdmin")); // stepKey: enterFirstNameCreateAdminUser
		$I->fillField("#user_lastname", "LastName" . msq("activeAdmin")); // stepKey: enterLastNameCreateAdminUser
		$I->fillField("#user_email", "AdminUser" . msq("activeAdmin") . "@magento.com"); // stepKey: enterEmailCreateAdminUser
		$I->fillField("#user_password", "123123q"); // stepKey: enterPasswordCreateAdminUser
		$I->fillField("#user_confirmation", "123123q"); // stepKey: confirmPasswordCreateAdminUser
		$I->selectOption("#page_tabs_main_section_content select[name='interface_locale']", "en_GB"); // stepKey: setInterfaceLocateCreateAdminUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterCurrentPasswordCreateAdminUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageCreateAdminUser
		$I->click("#page_tabs_roles_section"); // stepKey: clickUserRoleCreateAdminUser
		$I->click("//tr//td[contains(text(), 'Administrators')]"); // stepKey: chooseRoleCreateAdminUser
		$I->click("#save"); // stepKey: clickSaveUserCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForSaveTheUserCreateAdminUser
		$I->see("You saved the user."); // stepKey: seeSuccessMessageCreateAdminUser
		$I->comment("Exiting Action Group [createAdminUser] AdminCreateUserWithRoleAndLocaleActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "attribute" . msq("dateProductAttribute")); // stepKey: setAttributeCodeDeleteAttribute
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
		$I->comment("Entering Action Group [resetGridFilter] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopResetGridFilter
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersResetGridFilter
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetResetGridFilter
		$I->comment("Exiting Action Group [resetGridFilter] AdminGridFilterResetActionGroup");
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
	 * @Stories({"Filter products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductGridFilteringByDateWithCustomLocaleTest(AcceptanceTester $I)
	{
		$I->comment("Generate date for use as default value, needs to be MM/d/YYYY and mm/d/yy");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("now"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$generateDefaultDate = $date->format("m/j/Y");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("now"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$generateDefaultDateGB = $date->format("j/m/Y");

		$I->comment("Navigate to Stores > Attributes > Product.");
		$I->comment("Entering Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageGoToProductAttributes
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToProductAttributes
		$I->comment("Exiting Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->comment("Create new Product Attribute as TextField, with code and default value.");
		$I->comment("Entering Action Group [createAttribute] CreateProductAttributeWithDateFieldActionGroup");
		$I->click("#add"); // stepKey: createNewAttributeCreateAttribute
		$I->fillField("#attribute_label", "attribute" . msq("dateProductAttribute")); // stepKey: fillDefaultLabelCreateAttribute
		$I->selectOption("#frontend_input", "date"); // stepKey: checkInputTypeCreateAttribute
		$I->selectOption("#is_required", "No"); // stepKey: checkRequiredCreateAttribute
		$I->click("#advanced_fieldset-wrapper"); // stepKey: openAdvancedPropertiesCreateAttribute
		$I->fillField("#attribute_code", "attribute" . msq("dateProductAttribute")); // stepKey: fillCodeCreateAttribute
		$I->fillField("#default_value_date", $generateDefaultDate); // stepKey: fillDefaultValueCreateAttribute
		$I->click("#save"); // stepKey: saveAttributeCreateAttribute
		$I->waitForPageLoad(30); // stepKey: saveAttributeCreateAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [createAttribute] CreateProductAttributeWithDateFieldActionGroup");
		$I->comment("Go to default attribute set edit page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/edit/id/4/"); // stepKey: onAttributeSetEdit
		$I->comment("Assert created attribute in unassigned section");
		$I->see("attribute" . msq("dateProductAttribute"), "#tree-div2"); // stepKey: seeAttributeInUnassigned
		$I->comment("Assign attribute to a group");
		$I->comment("Entering Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='attribute" . msq("dateProductAttribute") . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttributeToGroup
		$I->see("attribute" . msq("dateProductAttribute"), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttributeToGroup
		$I->comment("Exiting Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->comment("Assert attribute in a group");
		$I->see("attribute" . msq("dateProductAttribute"), "#tree-div1"); // stepKey: seeAttributeInGroup
		$I->comment("Save attribute set");
		$I->comment("Entering Action Group [SaveAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSet
		$I->comment("Exiting Action Group [SaveAttributeSet] SaveAttributeSetActionGroup");
		$I->comment("Open Product Edit Page and set custom attribute value");
		$I->comment("Entering Action Group [searchForProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct
		$I->comment("Exiting Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->fillField("//fieldset[@class='admin__fieldset']//div[contains(@data-index,'attribute" . msq("dateProductAttribute") . "')]//input", $generateDefaultDate); // stepKey: fillCustomDateValue
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
		$I->comment("Logout master admin and Login as new User");
		$I->comment("Entering Action Group [logoutMasterAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutMasterAdmin
		$I->comment("Exiting Action Group [logoutMasterAdmin] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginToNewAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToNewAdmin
		$I->fillField("#username", "AdminUser" . msq("activeAdmin")); // stepKey: fillUsernameLoginToNewAdmin
		$I->fillField("#login", "123123q"); // stepKey: fillPasswordLoginToNewAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToNewAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToNewAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToNewAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToNewAdmin
		$I->comment("Exiting Action Group [loginToNewAdmin] AdminLoginActionGroup");
		$I->comment("Open Product Index Page and filter the product");
		$I->comment("Entering Action Group [navigateToProductIndex2] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex2
		$I->comment("Exiting Action Group [navigateToProductIndex2] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterProductGridByCustomDateRange] FilterProductGridByCustomDateRangeActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialFilterProductGridByCustomDateRange
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialFilterProductGridByCustomDateRangeWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridByCustomDateRange
		$I->fillField("input.admin__control-text[name='attribute" . msq("dateProductAttribute") . "[from]']", $generateDefaultDateGB); // stepKey: fillProductDatetimeFromFilterFilterProductGridByCustomDateRange
		$I->fillField("input.admin__control-text[name='attribute" . msq("dateProductAttribute") . "[to]']", $generateDefaultDateGB); // stepKey: fillProductDatetimeToFilterFilterProductGridByCustomDateRange
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridByCustomDateRange
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridByCustomDateRangeWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridByCustomDateRange
		$I->comment("Exiting Action Group [filterProductGridByCustomDateRange] FilterProductGridByCustomDateRangeActionGroup");
		$I->comment("Check products filtering");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "//tbody//tr//td//div[contains(., '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]"); // stepKey: seeProductName
		$I->waitForPageLoad(30); // stepKey: seeProductNameWaitForPageLoad
	}
}
