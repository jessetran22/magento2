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
 * @Title("MC-10906: Create Custom Product Attribute Text Field (Required) from Product Page")
 * @Description("Login as admin and create product attribute with Text Field and Required option<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateProductAttributeRequiredTextFieldTest.xml<br>")
 * @TestCaseId("MC-10906")
 * @group mtf_migrated
 */
class AdminCreateProductAttributeRequiredTextFieldTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create Category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Create Simple Product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created entity");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [deleteCreatedAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteCreatedAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteCreatedAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "attribute" . msq("newProductAttribute")); // stepKey: setAttributeCodeDeleteCreatedAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteCreatedAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteCreatedAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteCreatedAttribute
		$I->click("#delete"); // stepKey: deleteAttributeDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteCreatedAttributeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteCreatedAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteCreatedAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteCreatedAttribute
		$I->comment("Exiting Action Group [deleteCreatedAttribute] DeleteProductAttributeActionGroup");
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
	 * @Stories({"Manage products"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateProductAttributeRequiredTextFieldTest(AcceptanceTester $I)
	{
		$I->comment("Open Product Index Page");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Select Created Product");
		$I->comment("Entering Action Group [filterProductGridBySku] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridBySku
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridBySkuWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridBySku
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySkuWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku
		$I->comment("Exiting Action Group [filterProductGridBySku] FilterProductGridBySkuActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: openFirstProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoad
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQty
		$I->comment("Entering Action Group [selectStockStatus] AdminSetStockStatusActionGroup");
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: setStockStatusSelectStockStatus
		$I->waitForPageLoad(30); // stepKey: setStockStatusSelectStockStatusWaitForPageLoad
		$I->comment("Exiting Action Group [selectStockStatus] AdminSetStockStatusActionGroup");
		$I->comment("Create Product Attribute");
		$I->click("#addAttribute"); // stepKey: clickOnAddAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAddAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageToLoad
		$I->click("button[data-index='add_new_attribute_button']"); // stepKey: clickCreateNewAttributeButton
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForNewAttributePageToLoad
		$I->waitForElementVisible("input[name='frontend_label[0]']", 30); // stepKey: waitForDefaultLabelToBeVisible
		$I->fillField("input[name='frontend_label[0]']", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillAttributeLabel
		$I->selectOption("select[name='frontend_input']", "Text Field"); // stepKey: selectTextField
		$I->waitForPageLoad(30); // stepKey: selectTextFieldWaitForPageLoad
		$I->checkOption("//input[contains(@name,'is_required')]/..//label"); // stepKey: enableIsRequiredOption
		$I->click("//div[contains(@data-index,'advanced_fieldset')]"); // stepKey: clickOnAdvancedAttributeProperties
		$I->waitForElementVisible("//*[@class='admin__fieldset-wrapper-content admin__collapsible-content _show']//input[@name='attribute_code']", 30); // stepKey: waitForAttributeCodeToVisible
		$I->scrollTo("//*[@class='admin__fieldset-wrapper-content admin__collapsible-content _show']//input[@name='attribute_code']"); // stepKey: scrollToAttributeCode
		$I->fillField("//*[@class='admin__fieldset-wrapper-content admin__collapsible-content _show']//input[@name='attribute_code']", "attribute" . msq("newProductAttribute")); // stepKey: fillAttributeCode
		$I->selectOption("//*[@class='admin__fieldset-wrapper-content admin__collapsible-content _show']//select[@name='is_global']", "Global"); // stepKey: selectScope
		$I->waitForPageLoad(30); // stepKey: selectScopeWaitForPageLoad
		$I->fillField("//*[@class='admin__fieldset-wrapper-content admin__collapsible-content _show']//input[@name='default_value_text']", "white" . msq("ProductAttributeOption8")); // stepKey: fillDefaultValue
		$I->scrollTo("//input[contains(@name, 'is_unique')]/..//label"); // stepKey: scrollToIsUniqueOption
		$I->checkOption("//input[contains(@name, 'is_unique')]/..//label"); // stepKey: enableIsUniqueOption
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage
		$I->click("#save"); // stepKey: clickOnSaveAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAttributeToSave
		$I->comment("Entering Action Group [saveTheProduct] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonSaveTheProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveTheProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedSaveTheProduct
		$I->comment("Exiting Action Group [saveTheProduct] AdminProductFormSaveButtonClickActionGroup");
		$I->comment("Verify product attribute added in product form and Is Required message displayed");
		$I->scrollTo("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Content']"); // stepKey: scrollToContentTab
		$I->waitForElementVisible("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Attributes']", 30); // stepKey: waitForAttributeToVisible
		$I->seeElement("//*[@class='admin__field _required _error']/..//label[contains(.,'This is a required field.')]"); // stepKey: seeAttributeInputFiledErrorMessage
		$I->comment("Fill the Required field and save the product");
		$I->fillField("//input[contains(@name, 'product[attribute" . msq("newProductAttribute") . "]')]", "attribute"); // stepKey: fillTheAttributeRequiredInputField
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfProductFormPage
		$I->comment("Entering Action Group [saveTheProduct1] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonSaveTheProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveTheProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedSaveTheProduct1
		$I->comment("Exiting Action Group [saveTheProduct1] AdminProductFormSaveButtonClickActionGroup");
		$I->see("You saved the product.", ".message-success"); // stepKey: messageYouSavedTheProductIsShown
	}
}
