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
 * @Title("MAGETWO-96365: admin should be able to create a configurable product after incorrect sku")
 * @Description("admin should be able to create a configurable product after incorrect sku<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminConfigurableProductCreateTest/AdminCreateConfigurableProductAfterGettingIncorrectSKUMessageTest.xml<br>")
 * @TestCaseId("MAGETWO-96365")
 * @group ConfigurableProduct
 */
class AdminCreateConfigurableProductAfterGettingIncorrectSKUMessageTestCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Create, Read, Update, Delete"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateConfigurableProductAfterGettingIncorrectSKUMessageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigProduct', 'id', 'test')); // stepKey: goToProductGoToEditPage
		$I->comment("Exiting Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->conditionalClick(".admin__collapsible-block-wrapper[data-index='configurable']", "button[data-index='create_configurable_products_button']", false); // stepKey: openConfigurationSection
		$I->waitForPageLoad(30); // stepKey: openConfigurationSectionWaitForPageLoad
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: openConfigurationPane
		$I->waitForPageLoad(30); // stepKey: openConfigurationPaneWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFilters
		$I->fillField(".admin__control-text[name='attribute_code']", "color"); // stepKey: fillFilterAttributeCodeField
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButton
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckbox
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1WaitForPageLoad
		$I->waitForElementVisible(".action-create-new", 30); // stepKey: waitCreateNewValueAppears
		$I->waitForPageLoad(30); // stepKey: waitCreateNewValueAppearsWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue1
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue1WaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Red" . msq("colorProductAttribute2")); // stepKey: fillFieldForNewAttribute1
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute1
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute1WaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2WaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3WaitForPageLoad
		$I->click("//div[@class='nav-bar-outer-actions']//*[contains(text(),'Generate Products')]"); // stepKey: generateConfigure
		$I->waitForPageLoad(30); // stepKey: waitForGenerateConfigure
		$grabTextFromContent = $I->grabValueFrom("//input[@name='configurable-matrix[0][sku]']"); // stepKey: grabTextFromContent
		$I->fillField("//input[@name='configurable-matrix[0][sku]']", "01234567890123456789012345678901234567890123456789012345678901234"); // stepKey: fillMoreThan64Symbols
		$I->comment("Entering Action Group [saveProduct1] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct1
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct1
		$I->comment("Exiting Action Group [saveProduct1] AdminProductFormSaveActionGroup");
		$I->conditionalClick("//*[contains(@class,'product_form_product_form_configurable_attribute_set')]//button[@data-role='closeBtn']", "//*[contains(@class,'product_form_product_form_configurable_attribute_set')]//button[@data-role='closeBtn']", true); // stepKey: clickOnCloseInPopup
		$I->waitForPageLoad(30); // stepKey: clickOnCloseInPopupWaitForPageLoad
		$I->see("Please enter less or equal than 64 symbols."); // stepKey: seeErrorMessage
		$I->fillField("//input[@name='configurable-matrix[0][sku]']", "$grabTextFromContent"); // stepKey: fillCorrectSKU
		$I->comment("Entering Action Group [saveProduct2] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct2
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct2
		$I->comment("Exiting Action Group [saveProduct2] AdminProductFormSaveActionGroup");
		$I->conditionalClick("button[data-index='confirm_button']", "button[data-index='confirm_button']", true); // stepKey: clickOnConfirmInPopup
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupWaitForPageLoad
		$I->see("You saved the product."); // stepKey: seeSaveConfirmation
		$I->comment("Entering Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageGoToProductAttributes
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToProductAttributes
		$I->comment("Exiting Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGrid1
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGrid1WaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "color"); // stepKey: fillFilter
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickSearch
		$I->waitForPageLoad(30); // stepKey: clickSearchWaitForPageLoad
		$I->click("//td[contains(text(),'color')]"); // stepKey: clickRowToEdit
		$I->waitForPageLoad(30); // stepKey: clickRowToEditWaitForPageLoad
		$I->click("(//td[@class='col-delete'])[1]"); // stepKey: deleteOption
		$I->waitForPageLoad(30); // stepKey: deleteOptionWaitForPageLoad
		$I->click("#save"); // stepKey: saveAttribute
		$I->waitForPageLoad(30); // stepKey: saveAttributeWaitForPageLoad
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGrid2
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGrid2WaitForPageLoad
		$I->comment("Entering Action Group [deleteProduct1] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct1
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProduct1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct1
		$I->fillField("input.admin__control-text[name='sku']", "$grabTextFromContent"); // stepKey: fillProductSkuFilterDeleteProduct1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProduct1WaitForPageLoad
		$I->see("$grabTextFromContent", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct1
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct1
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct1
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProduct1WaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProduct1WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteProduct1
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteProduct1WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct1
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProduct1WaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteProduct1
		$I->comment("Exiting Action Group [deleteProduct1] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialWaitForPageLoad
	}
}
