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
 * @Title("[NO TESTCASEID]: Product Attribute label musts not contain HTML tags")
 * @Description("Test whenever HTML tags are allowed for a product attribute label<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminProductAttributeLabelDontAllowHtmlTagsTest.xml<br>")
 * @group catalog
 */
class AdminProductAttributeLabelDontAllowHtmlTagsTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAdmin
		$I->comment("Exiting Action Group [logoutAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Product Attribute label must not contain HTML tags"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductAttributeLabelDontAllowHtmlTagsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageOpenProductAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadOpenProductAttributePage
		$I->comment("Exiting Action Group [openProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->comment("Entering Action Group [fillAttributeDefaultLabel] AdminFillProductAttributePropertiesActionGroup");
		$I->fillField("#attribute_label", "Attribute Default label <span>" . msq("productAttributeWithHtmlTagsInLabel")); // stepKey: fillDefaultLabelFillAttributeDefaultLabel
		$I->selectOption("#frontend_input", "text"); // stepKey: selectInputTypeFillAttributeDefaultLabel
		$I->comment("Exiting Action Group [fillAttributeDefaultLabel] AdminFillProductAttributePropertiesActionGroup");
		$I->comment("Entering Action Group [makeManageLabelsTabActive] AdminProductAttributePageSwitchTabActionGroup");
		$I->click("#product_attribute_tabs a[title='Manage Labels']"); // stepKey: changeProductAttributeActiveTabMakeManageLabelsTabActive
		$I->comment("Exiting Action Group [makeManageLabelsTabActive] AdminProductAttributePageSwitchTabActionGroup");
		$I->comment("Entering Action Group [fillAttributeDefaultStoreViewLabel] AdminFillProductAttributeDefaultStoreViewActionGroup");
		$I->fillField("#attribute-labels-table [name='frontend_label[1]']", "Attribute Store label <span> " . msq("productAttributeWithHtmlTagsInLabel")); // stepKey: fillDefaultStoreViewLabelFillAttributeDefaultStoreViewLabel
		$I->comment("Exiting Action Group [fillAttributeDefaultStoreViewLabel] AdminFillProductAttributeDefaultStoreViewActionGroup");
		$I->comment("Entering Action Group [saveAttribute] AdminSaveProductAttributeActionGroup");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForSaveButtonSaveAttribute
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveAttributeWaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonSaveAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAttributeToSaveSaveAttribute
		$I->comment("Exiting Action Group [saveAttribute] AdminSaveProductAttributeActionGroup");
		$I->comment("Entering Action Group [validateAttributeStoreViewLabelForHtmlTags] AssertSeeProductAttributeValidationErrorOnManageLabelsTabActionGroup");
		$I->see("HTML tags are not allowed", "#attribute-labels-table .mage-error"); // stepKey: seeValidationMessageValidateAttributeStoreViewLabelForHtmlTags
		$I->comment("Exiting Action Group [validateAttributeStoreViewLabelForHtmlTags] AssertSeeProductAttributeValidationErrorOnManageLabelsTabActionGroup");
		$I->comment("Entering Action Group [makePropertiesTabActive] AdminProductAttributePageSwitchTabActionGroup");
		$I->click("#product_attribute_tabs a[title='Properties']"); // stepKey: changeProductAttributeActiveTabMakePropertiesTabActive
		$I->comment("Exiting Action Group [makePropertiesTabActive] AdminProductAttributePageSwitchTabActionGroup");
		$I->comment("Entering Action Group [validateAttributeLabelForHtmlTags] AssertSeeProductAttributeValidationErrorOnPropertiesTabActionGroup");
		$I->see("HTML tags are not allowed", ".field-attribute_label .mage-error"); // stepKey: seeValidationMessageValidateAttributeLabelForHtmlTags
		$I->comment("Exiting Action Group [validateAttributeLabelForHtmlTags] AssertSeeProductAttributeValidationErrorOnPropertiesTabActionGroup");
	}
}
