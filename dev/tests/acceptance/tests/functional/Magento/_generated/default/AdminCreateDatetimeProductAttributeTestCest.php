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
 * @Title("MC-21451: Datetime product attribute type is supported")
 * @Description("Admin should be able to create datetime product attribute<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateDatetimeProductAttributeTest.xml<br>")
 * @TestCaseId("MC-21451")
 * @group catalog
 */
class AdminCreateDatetimeProductAttributeTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "attribute" . msq("DatetimeProductAttribute")); // stepKey: setAttributeCodeDeleteAttribute
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
	 * @Stories({"Datetime product attributes support"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateDatetimeProductAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Generate the datetime default value");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("now"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$generateDefaultValue = $date->format("n/j/y g:i A");

		$I->comment("Create new datetime product attribute");
		$I->comment("Entering Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageGoToProductAttributes
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToProductAttributes
		$I->comment("Exiting Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->comment("Entering Action Group [createAttribute] CreateProductAttributeWithDatetimeFieldActionGroup");
		$I->click("#add"); // stepKey: createNewAttributeCreateAttribute
		$I->fillField("#attribute_label", "attribute" . msq("DatetimeProductAttribute")); // stepKey: fillDefaultLabelCreateAttribute
		$I->selectOption("#frontend_input", "datetime"); // stepKey: checkInputTypeCreateAttribute
		$I->selectOption("#is_required", "No"); // stepKey: checkRequiredCreateAttribute
		$I->scrollTo("#advanced_fieldset-wrapper"); // stepKey: scrollToAdvancedSectionCreateAttribute
		$I->conditionalClick("#advanced_fieldset-wrapper", "#attribute_code", false); // stepKey: openAdvancedSectionCreateAttribute
		$I->waitForElementVisible("#attribute_code", 30); // stepKey: waitForSlideOutAdvancedSectionCreateAttribute
		$I->fillField("#attribute_code", "attribute" . msq("DatetimeProductAttribute")); // stepKey: fillCodeCreateAttribute
		$I->scrollTo("#default_value_datetime"); // stepKey: scrollToDefaultFieldCreateAttribute
		$I->fillField("#default_value_datetime", $generateDefaultValue); // stepKey: fillDefaultValueCreateAttribute
		$I->click("#save"); // stepKey: saveAttributeCreateAttribute
		$I->waitForPageLoad(30); // stepKey: saveAttributeCreateAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [createAttribute] CreateProductAttributeWithDatetimeFieldActionGroup");
		$I->comment("Navigate to created product attribute");
		$I->comment("Entering Action Group [navigateToAttribute] NavigateToCreatedProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridNavigateToAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersNavigateToAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersNavigateToAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "attribute" . msq("DatetimeProductAttribute")); // stepKey: setAttributeCodeNavigateToAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridNavigateToAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridNavigateToAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowNavigateToAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowNavigateToAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToAttribute
		$I->comment("Exiting Action Group [navigateToAttribute] NavigateToCreatedProductAttributeActionGroup");
		$I->comment("Check the saved datetime default value");
		$I->comment("Entering Action Group [goToAdvancedSection] AdminNavigateToProductAttributeAdvancedSectionActionGroup");
		$I->scrollTo("#advanced_fieldset-wrapper"); // stepKey: scrollToSectionGoToAdvancedSection
		$I->conditionalClick("#advanced_fieldset-wrapper", "#attribute_code", false); // stepKey: openSectionGoToAdvancedSection
		$I->waitForElementVisible("#attribute_code", 30); // stepKey: waitForSlideOutSectionGoToAdvancedSection
		$I->comment("Exiting Action Group [goToAdvancedSection] AdminNavigateToProductAttributeAdvancedSectionActionGroup");
		$I->scrollTo("#default_value_datetime"); // stepKey: scrollToDefaultValue
		$I->seeInField("#default_value_datetime", $generateDefaultValue); // stepKey: checkDefaultValue
	}
}
