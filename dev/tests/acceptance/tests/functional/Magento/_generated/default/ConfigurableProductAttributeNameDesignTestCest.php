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
 * @Title("MAGETWO-93307: Generation of configurable products with an attribute named 'design'")
 * @Description("Generation of configurable products with an attribute named 'design'<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/ConfigurableProductAttributeNameDesignTest.xml<br>")
 * @TestCaseId("MAGETWO-93307")
 * @group product
 */
class ConfigurableProductAttributeNameDesignTestCest
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
		$I->comment("Log in to Dashboard page");
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Created Attribute");
		$I->comment("Entering Action Group [deleteCreatedAttribute] DeleteCreatedAttributeActionGroup");
		$I->comment("Click on Stores item");
		$I->click("//*[@id='menu-magento-backend-stores']/a/span"); // stepKey: clickOnStoresItemDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: waitForNavigationPanelDeleteCreatedAttribute
		$I->comment("Click on Products item");
		$I->waitForElementVisible("//*[@data-ui-id='menu-magento-catalog-catalog-attributes-attributes']/a", 30); // stepKey: waitForCatalogLoadDeleteCreatedAttribute
		$I->click("//*[@data-ui-id='menu-magento-catalog-catalog-attributes-attributes']/a"); // stepKey: clickOnStoresProductItemDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: waitForStoresProductPageLoadDeleteCreatedAttribute
		$I->comment("Click on created Attribute");
		$I->fillField("//*[@id='attributeGrid_filter_frontend_label']", "design"); // stepKey: searchProductDefaultLabelDeleteCreatedAttribute
		$I->click("//div[@class='admin__filter-actions']//*[contains(text(), 'Search')]"); // stepKey: clickSearchButtonDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: waitForCreatedAttributeLoadDeleteCreatedAttribute
		$I->click("//td[contains(@class, 'col-label') and normalize-space()='design']"); // stepKey: clickOnCreatedAttributeItemDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: waitForAttributePropertiesPageLoadDeleteCreatedAttribute
		$I->comment("Click on Delete Attribute item");
		$I->click("//*[@id='delete']"); // stepKey: clickOnDeleteAttributeItemDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: waitForDeletedDialogOpenedDeleteCreatedAttribute
		$I->comment("Click on OK button");
		$I->click("//footer[@class='modal-footer']//*[contains(text(),'OK')]"); // stepKey: clickOnOKButtonDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: waitFordAttributeDeletedDeleteCreatedAttribute
		$I->see("You deleted the product attribute."); // stepKey: seeDeletedTheProductAttributeMessageDeleteCreatedAttribute
		$I->comment("Click Reset Filter button");
		$I->click("//span[contains(text(), 'Reset Filter')]"); // stepKey: clickResetFilterButtonDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: waitForAllFilterResetDeleteCreatedAttribute
		$I->comment("Exiting Action Group [deleteCreatedAttribute] DeleteCreatedAttributeActionGroup");
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
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Stories({"MAGETWO-91524 : 'element.disabled is not a function' error is thrown when configurable products are generated with an attribute named 'design'"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ConfigurableProductAttributeNameDesignTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to Catalog-> Products");
		$I->comment("Entering Action Group [goToCatalogProductsPage] GotoCatalogProductsPageActionGroup");
		$I->click("//*[@id='menu-magento-catalog-catalog']/a/span"); // stepKey: clickOnCatalogItemGoToCatalogProductsPage
		$I->waitForPageLoad(30); // stepKey: waitForCatalogLoadGoToCatalogProductsPage
		$I->click("//*[@data-ui-id='menu-magento-catalog-catalog-products']/a"); // stepKey: clickOnProductItemGoToCatalogProductsPage
		$I->waitForPageLoad(30); // stepKey: waitForCatalogProductPageLoadGoToCatalogProductsPage
		$I->seeInCurrentUrl("product"); // stepKey: assertWeAreOnTheCatalogProductPageGoToCatalogProductsPage
		$I->comment("Exiting Action Group [goToCatalogProductsPage] GotoCatalogProductsPageActionGroup");
		$I->comment("Fill the fields on Configurable Product");
		$I->comment("Entering Action Group [goToConfigurableProductPage] GotoConfigurableProductPageActionGroup");
		$I->click("//*[@id='add_new_product']/button[2]"); // stepKey: clickOnAddProductItemGoToConfigurableProductPage
		$I->click("//*[@id='add_new_product']//*[contains(text(),'Configurable Product')]"); // stepKey: clickOnConfigurationProductItemGoToConfigurableProductPage
		$I->waitForPageLoad(30); // stepKey: waitForConfigurableProductPageLoadGoToConfigurableProductPage
		$I->seeInCurrentUrl("configurable"); // stepKey: assertWeAreOnTheConfigurableProductPageGoToConfigurableProductPage
		$I->comment("Exiting Action Group [goToConfigurableProductPage] GotoConfigurableProductPageActionGroup");
		$I->comment("Entering Action Group [fillInAllRequiredFields] FillAllRequiredFieldsActionGroup");
		$I->fillField("//input[@name='product[name]']", msq("NewProductsData") . "Shoes"); // stepKey: fillInProductNameFieldsFillInAllRequiredFields
		$I->fillField("//input[@name='product[price]']", "60"); // stepKey: fillInPriceFieldsFillInAllRequiredFields
		$I->fillField("//input[@name='product[weight]']", "100"); // stepKey: fillInWeightFieldsFillInAllRequiredFields
		$I->click("//*[contains(text(),'Create Configurations')]"); // stepKey: clickOnCreateConfigurationsButtonFillInAllRequiredFields
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductConfigurationsPageLoadFillInAllRequiredFields
		$I->click("//*[contains(text(),'Create New Attribute')]"); // stepKey: clickOnCreateNewAttributeButtonFillInAllRequiredFields
		$I->waitForPageLoad(30); // stepKey: waitForNewAttributePageLoadFillInAllRequiredFields
		$I->comment("Exiting Action Group [fillInAllRequiredFields] FillAllRequiredFieldsActionGroup");
		$I->comment("Create New Attribute (Default Label= design)");
		$I->comment("Entering Action Group [createNewAttribute] CreateNewAttributeActionGroup");
		$I->switchToIFrame("create_new_attribute_container"); // stepKey: NewAttributePageCreateNewAttribute
		$I->fillField("//*[@id='attribute_label']", "design"); // stepKey: fillInDefaultLabelFieldCreateNewAttribute
		$I->comment("Add option 1 to attribute");
		$I->click("//*[@id='add_new_option_button']"); // stepKey: clickAddOption1CreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: waitForOption1CreateNewAttribute
		$I->fillField("//input[@name='option[value][option_0][0]']", "red"); // stepKey: fillInAdminFieldRedCreateNewAttribute
		$I->fillField("//input[@name='option[value][option_0][1]']", "red123"); // stepKey: fillInDefaultStoreViewFieldRedCreateNewAttribute
		$I->comment("Add option 2 to attribute");
		$I->click("//*[@id='add_new_option_button']"); // stepKey: clickAddOption2CreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: waitForOption2CreateNewAttribute
		$I->fillField("//input[@name='option[value][option_1][0]']", "blue"); // stepKey: fillInAdminFieldBlueCreateNewAttribute
		$I->fillField("//input[@name='option[value][option_1][1]']", "blue123"); // stepKey: fillInDefaultStoreViewFieldBlueCreateNewAttribute
		$I->comment("Add option 3 to attribute");
		$I->click("//*[@id='add_new_option_button']"); // stepKey: clickAddOption3CreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: waitForOption3CreateNewAttribute
		$I->fillField("//input[@name='option[value][option_2][0]']", "yellow"); // stepKey: fillInAdminFieldYellowCreateNewAttribute
		$I->fillField("//input[@name='option[value][option_2][1]']", "yellow123"); // stepKey: fillInDefaultStoreViewFieldYellowCreateNewAttribute
		$I->comment("Add option 4 to attribute");
		$I->click("//*[@id='add_new_option_button']"); // stepKey: clickAddOption4CreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: waitForOption4CreateNewAttribute
		$I->fillField("//input[@name='option[value][option_3][0]']", "green"); // stepKey: fillInAdminFieldGreenCreateNewAttribute
		$I->fillField("//input[@name='option[value][option_3][1]']", "green123"); // stepKey: fillInDefaultStoreViewFieldGreenCreateNewAttribute
		$I->comment("Add option 5 to attribute");
		$I->click("//*[@id='add_new_option_button']"); // stepKey: clickAddOption5CreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: waitForOption5CreateNewAttribute
		$I->fillField("//input[@name='option[value][option_4][0]']", "black"); // stepKey: fillInAdminFieldBlackCreateNewAttribute
		$I->fillField("//input[@name='option[value][option_4][1]']", "black123"); // stepKey: fillInDefaultStoreViewFieldBlackCreateNewAttribute
		$I->comment("Click Save Attribute button");
		$I->click("//*[@id='save']"); // stepKey: clickSaveAttributeButtonCreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: waitForSavingSettingsCreateNewAttribute
		$I->comment("Select created Attribute");
		$I->click("//*[@class='admin__data-grid-wrap']//td[normalize-space()='design']/preceding-sibling::td"); // stepKey: selectCreatedAttributeCreateNewAttribute
		$I->comment("Click Next button");
		$I->click("//div[@class='nav-bar-outer-actions']//*[contains(text(),'Next')]"); // stepKey: clickNextButtonCreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: waitForNextPageLoadedCreateNewAttribute
		$I->comment("Select all the options of all the attributes button");
		$I->click("//fieldset[@class='admin__fieldset admin__fieldset-options']//*[contains(text(),'red')]/preceding-sibling::input"); // stepKey: selectCheckboxRedCreateNewAttribute
		$I->click("//fieldset[@class='admin__fieldset admin__fieldset-options']//*[contains(text(),'blue')]/preceding-sibling::input"); // stepKey: selectCheckboxBlueCreateNewAttribute
		$I->click("//fieldset[@class='admin__fieldset admin__fieldset-options']//*[contains(text(),'yellow')]/preceding-sibling::input"); // stepKey: selectCheckboxYellowCreateNewAttribute
		$I->click("//fieldset[@class='admin__fieldset admin__fieldset-options']//*[contains(text(),'green')]/preceding-sibling::input"); // stepKey: selectCheckboxGreenCreateNewAttribute
		$I->click("//fieldset[@class='admin__fieldset admin__fieldset-options']//*[contains(text(),'black')]/preceding-sibling::input"); // stepKey: selectCheckboxBlackCreateNewAttribute
		$I->comment("Click Next button");
		$I->click("//div[@class='nav-bar-outer-actions']//*[contains(text(),'Next')]"); // stepKey: clickNextButton2CreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: waitForBulkImagesPricePageLoadedCreateNewAttribute
		$I->comment("Click Next button");
		$I->click("//div[@class='nav-bar-outer-actions']//*[contains(text(),'Next')]"); // stepKey: clickNextButton3CreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: waitForSummaryPageLoadedCreateNewAttribute
		$I->comment("Click Generate Configure button");
		$I->click("//div[@class='nav-bar-outer-actions']//*[contains(text(),'Generate Products')]"); // stepKey: generateConfigureCreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: waitForGenerateConfigureCreateNewAttribute
		$I->comment("This Error message shouldn't appear: Test will pass when bug will be fixed");
		$I->dontSee("element.disabled is not a function", "//div[@data-ui-id='messages-message-error']"); // stepKey: dontSeeErrorCreateNewAttribute
		$I->comment("Close frame");
		$I->conditionalClick("//*[@class='modal-header']//*[contains(text(),'Create Product Configurations')]/following-sibling::button", "//*[@class='modal-header']//*[contains(text(),'Create Product Configurations')]/following-sibling::button", 1); // stepKey: closeFrameCreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: waitForClosingFrameCreateNewAttribute
		$I->comment("Exiting Action Group [createNewAttribute] CreateNewAttributeActionGroup");
	}
}
