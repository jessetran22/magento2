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
 * @Title("MC-30362: Create Custom Product Attribute Dropdown Field (Not Required) from Product Page after closing the new attribute window multiple times")
 * @Description("login as admin and create simple product attribute Dropdown field after closing the new attribute window multiple times<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminVerifyCreateCloseCreateCustomProductAttributeTest.xml<br>")
 * @TestCaseId("MC-30362")
 * @group catalog
 */
class AdminVerifyCreateCloseCreateCustomProductAttributeTestCest
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
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
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
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [deleteCreatedAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeGridPageLoadDeleteCreatedAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridDeleteCreatedAttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label']", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: setAttributeLabelFilterDeleteCreatedAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeLabelFromTheGridDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeLabelFromTheGridDeleteCreatedAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteCreatedAttributeWaitForPageLoad
		$I->click("#delete"); // stepKey: clickOnDeleteAttributeButtonDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteAttributeButtonDeleteCreatedAttributeWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmationPopUpVisibleDeleteCreatedAttribute
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOnConfirmationButtonDeleteCreatedAttribute
		$I->waitForPageLoad(60); // stepKey: clickOnConfirmationButtonDeleteCreatedAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageVisibleDeleteCreatedAttribute
		$I->see("You deleted the product attribute.", "#messages div.message-success"); // stepKey: seeAttributeDeleteSuccessMessageDeleteCreatedAttribute
		$I->comment("Exiting Action Group [deleteCreatedAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->comment("Entering Action Group [logoutFromAdminPanel] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdminPanel
		$I->comment("Exiting Action Group [logoutFromAdminPanel] AdminLogoutActionGroup");
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
	 * @Stories({"Create product Attribute after closing the new attribute window multiple times"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminVerifyCreateCloseCreateCustomProductAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductNavigateToProductPage
		$I->comment("Exiting Action Group [navigateToProductPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Attribute creation");
		$I->click("#addAttribute"); // stepKey: clickOnAddAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAddAttributeWaitForPageLoad
		$I->waitForElementVisible("button[data-index='add_new_attribute_button']", 30); // stepKey: waitForCreateBtn
		$I->waitForPageLoad(30); // stepKey: waitForCreateBtnWaitForPageLoad
		$I->click("button[data-index='add_new_attribute_button']"); // stepKey: clickCreateNewAttributeButton
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeButtonWaitForPageLoad
		$I->waitForElementVisible("input[name='frontend_label[0]']", 30); // stepKey: waitForLabelInput
		$I->comment("Close creation window few times");
		$I->click("#cancel"); // stepKey: clickCloseNewAttributeWindowButton
		$I->waitForPageLoad(30); // stepKey: clickCloseNewAttributeWindowButtonWaitForPageLoad
		$I->waitForElementVisible("button[data-index='add_new_attribute_button']", 30); // stepKey: waitForCreateBtn2
		$I->waitForPageLoad(30); // stepKey: waitForCreateBtn2WaitForPageLoad
		$I->click("button[data-index='add_new_attribute_button']"); // stepKey: clickCreateNewAttributeButton2
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeButton2WaitForPageLoad
		$I->waitForElementVisible("input[name='frontend_label[0]']", 30); // stepKey: waitForLabelInput2
		$I->click("#cancel"); // stepKey: clickCloseNewAttributeWindowButton2
		$I->waitForPageLoad(30); // stepKey: clickCloseNewAttributeWindowButton2WaitForPageLoad
		$I->waitForElementVisible("button[data-index='add_new_attribute_button']", 30); // stepKey: waitForCreateBtn3
		$I->waitForPageLoad(30); // stepKey: waitForCreateBtn3WaitForPageLoad
		$I->click("button[data-index='add_new_attribute_button']"); // stepKey: clickCreateNewAttributeButton3
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeButton3WaitForPageLoad
		$I->waitForElementVisible("input[name='frontend_label[0]']", 30); // stepKey: waitForLabelInput3
		$I->comment("Fill attribute data and save");
		$I->fillField("input[name='frontend_label[0]']", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillAttributeLabel
		$I->selectOption("select[name='frontend_input']", "Dropdown"); // stepKey: setInputType
		$I->waitForPageLoad(30); // stepKey: setInputTypeWaitForPageLoad
		$I->click("//div[contains(@data-index,'advanced_fieldset')]"); // stepKey: clickOnAdvancedAttributeProperties
		$I->waitForElementVisible("//*[@class='admin__fieldset-wrapper-content admin__collapsible-content _show']//input[@name='attribute_code']", 30); // stepKey: waitForAttributeCodeToVisible
		$I->fillField("//*[@class='admin__fieldset-wrapper-content admin__collapsible-content _show']//input[@name='attribute_code']", "attribute" . msq("newProductAttribute")); // stepKey: fillAttributeCode
		$I->scrollTo("//div[contains(@data-index,'front_fieldset')]"); // stepKey: scrollToStorefrontProperties
		$I->click("//div[contains(@data-index,'front_fieldset')]"); // stepKey: clickOnStorefrontProperties
		$I->waitForElementVisible("//input[contains(@name, 'is_searchable')]/..//label", 30); // stepKey: waitForStoreFrontProperties
		$I->checkOption("//input[contains(@name, 'is_searchable')]/..//label"); // stepKey: enableInSearchOption
		$I->checkOption("//input[contains(@name, 'is_visible_in_advanced_search')]/..//label"); // stepKey: enableAdvancedSearch
		$I->checkOption("//input[contains(@name, 'is_visible_on_front')]/..//label"); // stepKey: enableVisibleOnStorefront
		$I->checkOption("//input[contains(@name, 'is_visible_on_front')]/..//label"); // stepKey: enableSortProductListing
		$I->comment("Entering Action Group [createDropdownOption] AdminAddOptionForDropdownAttributeActionGroup");
		$I->scrollTo("//button[contains(@data-action,'add_new_row')]"); // stepKey: scrollToOptionCreateDropdownOption
		$I->waitForPageLoad(30); // stepKey: scrollToOptionCreateDropdownOptionWaitForPageLoad
		$I->click("//button[contains(@data-action,'add_new_row')]"); // stepKey: clickOnAddValueButtonCreateDropdownOption
		$I->waitForPageLoad(30); // stepKey: clickOnAddValueButtonCreateDropdownOptionWaitForPageLoad
		$I->waitForElementVisible("//input[contains(@name,'option[value][option_0][1]')]", 30); // stepKey: waitForDefaultStoreViewToVisibleCreateDropdownOption
		$I->fillField("//input[contains(@name,'option[value][option_0][1]')]", "White" . msq("ProductAttributeOption8")); // stepKey: fillDefaultStoreViewCreateDropdownOption
		$I->fillField("//input[contains(@name,'option[value][option_0][0]')]", "White" . msq("ProductAttributeOption8")); // stepKey: fillAdminFieldCreateDropdownOption
		$I->comment("Exiting Action Group [createDropdownOption] AdminAddOptionForDropdownAttributeActionGroup");
		$I->checkOption("//tr[1]//input[contains(@name,'default[]')]"); // stepKey: selectRadioButton
		$I->click("#save"); // stepKey: clickOnSaveAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAttributeWaitForPageLoad
		$I->comment("Check if the product page after attribute save");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: seeRedirectToProductPage
	}
}
